<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Withdraw;
use App\Models\User;
use App\Models\Rate;
use App\Models\Plan;

class WithdrawController extends Controller
{
    public function handleWithdraw(Request $request)
    {
        switch ($request->method()) {
            case 'GET':
                return $this->getWithdraws($request);
            case 'POST':
                return $this->store($request);
            default:
                return response()->json(['status' => false, 'message' => 'Invalid request method'], 405);
        }
    }

    public function getWithdraws(Request $request)
    {
        if (!Auth::guard('sanctum')->check()) {
            return response()->json([
                'status' => false,
                'error' => __('User not authenticated')
            ], 401);
        }
        $user = Auth::guard('sanctum')->user();
        $withdraws = Withdraw::with('currency:id,name')
            ->where('user_id', $user->id)->get();
        $withdraws->each(function ($withdraw) {
            $withdraw->currency->makeHidden(['id']);
        });
        return response()->json([
            'status' => true,
            'withdraws' => $withdraws,
        ]);
    }
    public function getWithdrawRates(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $from_binance_rates = Rate::where([
            ['plan_id', $user->plan_id],
            ['from', 1]
        ])->get()->map(function ($rate) {
            return [
                'price' => $rate->price,
                'updated_at' => $rate->updated_at,
                'currency_name' => $rate->toCurrency->name,
                'to' => $rate->toCurrency->id,
            ];
        });
        $total_withdrawals =  Withdraw::where('user_id', $user->id)->sum('amount');
        return response()->json([
            'status' => true,
            'total_withdrawals' => $total_withdrawals,
            'from_binance_rates' => $from_binance_rates,
        ]);
    }
    public function store(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'error' => __('User not found')
            ], 404);
        }

        if ($request->amount > $user->balance) {
            return response()->json([
                'status' => false,
                'error' => __("You don't have enough balance")
            ], 400);
        }

        try {
            Withdraw::create([
                'user_id' => $user->id,
                'method' => $request->method,
                'amount' => $request->amount,
                'receiving_account_number' => $request->receiving_account_number,
            ]);
            $user->decrement('balance', $request->amount);
            return response()->json([
                'status' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => __('An error occurred while processing the request')
            ], 500);
        }
    }
}
