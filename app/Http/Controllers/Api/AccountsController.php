<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Account;
use App\Models\Currency;

class AccountsController extends Controller
{
   public function handleAccounts(Request $request)
    {
        switch ($request->method()) {
            case 'GET':
                return $this->getAccounts($request);
            case 'PATCH':
                return $this->updateAccountNumbers($request);
            default:
                return response()->json(['status' => false, 'message' => 'Invalid request method']);
        }
    }
 public function getAccounts(Request $request)
{
    try {
        $user = Auth::guard('sanctum')->user();
        $userId = $user->id;
        $accounts = Account::where('user_id', $userId)->get();
        $currencies = Currency::all();
        $userCurrencyIds = $accounts->pluck('bank_id')->toArray();
        foreach ($currencies as $currency) {
            if (!in_array($currency->id, $userCurrencyIds)) {
                Account::create([
                    'user_id' => $userId,
                    'bank_id' => $currency->id,
                    'comment' => 'Account for user ' . $userId . ' with currency ' . $currency->name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        $accounts = Account::where('user_id', $userId)
            ->with(['currency:id,name'])->get()
             ->map(function ($account) {
             $account->currency->makeHidden('id'); 
             return $account;
        });  
            return response()->json([
                    'status' => true,
                    'accounts' => $accounts,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'error' => $e->getMessage(),
        ], 500);
    }
}
public function updateAccountNumbers(Request $request)
{
    try {
        $user = Auth::guard('sanctum')->user();
        $accountsData = $request->input('accounts');
        if (!$accountsData || !is_array($accountsData)) {
            return response()->json([
                'status' => false,
                'error' => 'Invalid data format.',
            ], 400);
        }
        foreach ($accountsData as $accountData) {
            $account = Account::where('id', $accountData['id'])->first();
            if ($account) {
                $account->update([
                    'account_number' => $accountData['account_number'] ?? $account->account_number,
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'error' => 'Account with ID ' . $accountData['id'] . ' not found.',
                ], 404);
            }
        }
        return response()->json([
            'status' => true,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'error' => $e->getMessage(),
        ], 500);
    }
}

}
