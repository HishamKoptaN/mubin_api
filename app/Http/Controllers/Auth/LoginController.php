<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()->first()
            ]);
        }
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => false,
                'error' => __('The provided credentials do not match our records.')
            ]);
        }
        try {
            $user = Auth::user();

            if ($user) {
                if ($user->status == 'inactive') {
                    return response()->json([
                        'status' => false,
                        'error' => __('You have been blocked from the platform.')
                    ]);
                }

                $token = $user->createToken("auth", ['*'], now()->addWeek());
                return response()->json([
                    'status' => true,
                    'token' => $token->plainTextToken,
                    'user' => $user
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage(),
            ]);
        }
        return response()->json([
            'status' => false,
            'error' => __('Error try again later.'),
        ]);
    }
}
