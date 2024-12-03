<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    use ApiResponseTrait;
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
