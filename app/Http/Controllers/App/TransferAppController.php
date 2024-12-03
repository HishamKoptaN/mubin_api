<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use App\Models\Transfer;

class TransferAppController extends Controller
{
    use ApiResponseTrait;

    public function handleRequest(Request $request, $account_number = null)
    {
        switch ($request->method()) {
            case 'GET':
                return $this->get($account_number);
            case 'POST':
                return $this->transferMoney($request, $account_number);
            default:
                return $this->failureResponse('Invalid request method', 405);
        }
    }

    protected function get($account_number)
    {
        $user = $this->findUserByAccount($account_number);
        if (!$user) {
            return $this->failureResponse(__('User not found'), 404);
        }

        return $this->successResponse([
            'name' => $user->name,
        ]);
    }

    public function transferMoney(Request $request)
    {
        $validated = $request->validate([
            'account_number' => 'required|string', // تحقق من أن account_number موجود
            'amount' => 'required|numeric|min:1', // تحقق من أن المبلغ صالح
        ]);
        $me = Auth::guard('sanctum')->user(); // المستخدم الحالي
        $user = User::where('account_number', $validated['account_number'])->first(); // البحث عن المستخدم الآخر
        // التحقق من وجود المستخدم
        if (!$user) {
            return $this->failureResponse(__('User not found'), 404);
        }
        // التحقق من الرصيد
        if ($validated['amount'] > $me->balance) {
            return $this->failureResponse(__('You don\'t have enough balance'), 400);
        }
        // إجراء التحويل
        $me->decrement('balance', $validated['amount']); // خصم من رصيد المستخدم الحالي
        $user->increment('balance', $validated['amount']); // إضافة لرصيد المستخدم المستقبل
        return $this->successResponse([
            'message' => __('Transfer successful'),
        ]);
    }


    public function index(Request $request)
    {
        $transactions = Transfer::with(['receiver', 'senderCurrency', 'receiverCurrency'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return $this->successResponse([
            'transactions' => $transactions,
            'user' => $request->user(),
        ]);
    }

    private function findUserByAccount($account_number)
    {
        return User::where('account_number', $account_number)->first();
    }
}
