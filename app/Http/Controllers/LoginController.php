<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
   public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required'
    ]);
    $credentials = [
        'email' => $request->email,
        'password' => $request->password
    ];
    if ($validator->fails()) {
        \Log::info('Validation failed', ['errors' => $validator->errors()]);
        return response()->json([
            'status' => false,
            'error' => $validator->errors()->first()
        ]);
    }
    $authenticate = Auth::attempt($credentials);
    \Log::info('Authentication result', ['authenticate' => $authenticate]);
    if (!$authenticate) {
        return response()->json([
            'status' => false,
            'error' => __('The provided credentials do not match our records.')
        ]);
    }
    try {
        $user = $request->user();
        \Log::info('User fetched', ['user' => $user]);
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
                'token' => $token->plainTextToken
            ]);
        }
    } catch (\Throwable $th) {
        \Log::error('Error occurred', ['exception' => $th]);
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
