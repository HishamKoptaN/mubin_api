<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Currency;
use App\Models\Account;

class RegisterController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|max:100|confirmed',
            'address' => "required|string|max:100",
            'phone' => "required|string|max:100|unique:users,phone",
            'code' => "nullable|string",
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()->first()
            ]);
        }
        try {
            $ref = null;
            if ($request->code) {
                $ref = User::where('refcode', $request->code)->first();
            }
            $currencies = Currency::get();
            $account_info = [];
            foreach ($currencies as $currency) {
                $account_info[] = [
                    'currency' => $currency->name,
                    'value' => '',
                ];
            }
            $user = User::create([
                'status' => 'active',
                'token' => sha1(str()->random()),
                'name' => $request->name,
                'username' => $request->name . "." . str()->random(2),
                'password' => Hash::make($request->password),
                'email' => $request->email,
                'account_number' => '24' . rand(11111, 99999),
                'image' => "default.png",
                'address' => $request->address,
                'phone' => $request->phone,
                'phone_verified_at' => null,
                'balance' => 0,
                'phone_verification_code' => null,
                'inactivate_end_at' => null,
                'message' => rand(11111, 99999),
                'refcode' => strtoupper(str()->random(6)),
                'refered_by' => $ref ? $ref->id : null,
                'plan_id' => 1
            ]);
            if ($user) {
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
