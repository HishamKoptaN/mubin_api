<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transfer;

class TransferController extends Controller
{
    public function handleTransfer(Request $request, $account_number = null)
    {
        switch ($request->method()) {
            case 'GET':
                return $this->getTransfer($request, $account_number);
            case 'POST':
                return $this->transferMoney($request, $account_number);
            default:
                return response()->json(['status' => false, 'message' => 'Invalid request method'], 405);
        }
    }

    protected function getTransfer(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'error' => __('User not found')
            ], 404);
        }
        return response()->json([
            'status' => true,
            'name' => $user->name
        ]);
    }

    public function transferMoney(Request $request, $account_number)
    {
        $me = Auth::guard('sanctum')->user();
        $user = User::where('account_number', $account_number)->first();
        if (!$user) {
            return response()->json([
                'status' => false,
                'error' => __('User not found')
            ], 404);
        }
        if ($request->amount > $me->balance) {
            return response()->json([
                'status' => false,
                'error' => __('You don\'t have enough balance')
            ], 400);
        }
        $me->decrement('balance', $request->amount);
        $user->increment('balance', $request->amount);
        return response()->json([
            'status' => true
        ]);
    }

    public function index(Request $request)
    {
        $transactions = Transfer::with([
            "receiver",
            "senderCurrency",
            "receiverCurrency",
        ])
            ->where('user_id', $request->user()->id)
            ->latest()->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'transactions' => $transactions,
            'user' => $request->user()
        ]);
    }
}
