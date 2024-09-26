<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'currentPassword' => 'required',
            'newPassword' => 'required|max:200|string|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()->first()
            ]);
        }

        if (!Hash::check($request->currentPassword, $request->user()->password)) {
            return response()->json([
                'status' => false,
                'error' => __('Current password is not valid')
            ]);
        }

        $request->user()->update([
            'password' => Hash::make($request->newPassword)
        ]);

        return response()->json([
            'status' => true,
            'user' => $request->user()
        ]);
    }
}
