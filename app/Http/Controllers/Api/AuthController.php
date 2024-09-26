<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Mail\ActivationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
class AuthController extends Controller
{ 
    public function sendActivationEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->email_verified_at) {
            return response()->json(['message' => 'Email already verified'], 400);
        }

        $token = JWTAuth::fromUser($user);
        Mail::to($user->email)->send(new ActivationMail($token));
        return response()->json(['message' => 'Activation email sent']);
    }

    public function verify(Request $request)
    {
        $token = $request->query('token');

        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid token'], 400);
        }

        $user->email_verified_at = now();
        $user->save();
        return response()->json(['message' => 'Email successfully verified']);
    }
    public function logout(Request $request)
    {
        // الحصول على المستخدم الحالي
        $user = Auth::user();

        if ($user) {
            // تسجيل خروج المستخدم
            $user->token()->revoke();

            return response()->json([
                'status' => true,
                'message' => 'Successfully logged out',
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'User is not logged in',
        ], 401);
    }
}
