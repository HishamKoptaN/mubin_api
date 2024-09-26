<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Models\Currency;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginGoogleController extends Controller
{

    public function googleLogin(Request $request)
    {
        $create_password = false;
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'name' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()->first()
            ]);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $create_password = true;
            $user = User::create([
                'status' => "active",
                'token' => str()->random(),
                'name' => $request->name,
                'username' => $request->name . '-' . str()->random(3),
                'password' => Hash::make(str()->random()),
                'email' => $request->email,
                'image' => "default.png",
                'address' => null,
                'phone' => null,
                'phone_verified_at' => null,
                'balance' => 0,
                'phone_verification_code' => null,
                'inactivate_end_at' => null,
                'message' => null,
                'refcode' => strtoupper(str()->random(6)),
                'account_info' => "",
                'email_verified_at' => now(),
                'refered_by' => null,
                'plan_id' => 1,
            ]);

            $currencies = Currency::get();
            $account_info = [];

            foreach ($currencies as $currency) {
                $account_info[] = [
                    'currency' => $currency->name,
                    'value' => "",
                ];
            }

            $user->account_info = $account_info;
            $user->save();

            $user->markEmailAsVerified();

            $user->assignRole('Member');
        }

        try {
            if ($user) {
                $token = $user->createToken("auth", ['*'], now()->addWeek());

                return response()->json([
                    'status' => true,
                    'create_password' => $create_password,
                    'token' => $token->plainTextToken
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
