<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\OpportunityLooking;
use App\Models\Company;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    protected $firebaseAuth;
    public function __construct()
    {
        $credentialsPath = base_path('storage/app/firebase/firebase_credentials.json');
        if (!file_exists($credentialsPath)) {
            throw new \Exception('Firebase credentials file is missing.');
        }
        $this->firebaseAuth = (new Factory)
            ->withServiceAccount($credentialsPath)
            ->createAuth();
    }
    public function authToken(Request $request)
    {
        $id_token = $request->input('id_token');
        try {
            $verifiedIdToken = $this->firebaseAuth->verifyIdToken(
                $id_token,
            );
            $firebaseUid = $verifiedIdToken->claims()->get('sub');
            $user = User::where('firebase_uid', $firebaseUid)->first();
            $token = $user->createToken("auth", ['*'], now()->addWeek())->plainTextToken;
            return successRes(
                [
                    'token' => $token,
                    'role' => $user->getRoleNames()->first(),
                ],
            );
        } catch (\Exception $e) {
            return failureRes(
                $e->getMessage(),
                401,
            );
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->failureResponse(
                $validator->errors()->first(),
            );
        }
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (!Auth::attempt($credentials)) {
            return $this->failureResponse(
                __('The provided credentials do not match our records.'),
            );
        }
        try {
            $user = Auth::user();
            if ($user) {
                if (!$user->status) {
                    return $this->failureResponse(
                        __('You have been blocked from the platform.'),
                    );
                }
                $token = $user->createToken("auth", ['*'], now()->addWeek());
                return $this->successResponse(
                    [
                        'token' => $token->plainTextToken,
                        'user' => $user
                    ],
                );
            }
        } catch (\Throwable $th) {
            return $this->failureResponse(
                $th->getMessage(),
            );
        }
    }
}
