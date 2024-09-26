<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Models\Currency;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginGoogleCompleteController extends Controller
{
    public function completeGoogleLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|max:100|confirmed',
            'code' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()->first()
            ]);
        }

        $request->user()->update([
            'password' => Hash::make($request->password),
            'code' => $request->code
        ]);

        return [
            'status' => true,
        ];
    }
}
