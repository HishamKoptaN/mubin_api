<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Account;
use App\Models\Currency;

class AccountsDashboardController extends Controller
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
public function getAccounts()
{
    try {
        // التحقق من تسجيل دخول المستخدم
        $user = Auth::guard('sanctum')->user();  
        if (!$user) {
            return response()->json([
                'status' => false,
                'error' => 'User not authenticated',
            ], 401);
        }

        // جلب الحسابات المرتبطة بالمستخدم
        $accounts = Account::where('user_id', $user->id)
            ->with(['currency:id,name'])
            ->get()
            ->map(function ($account) {
                $account->currency->makeHidden('id'); 
                return $account;
            });

        // التحقق من حالة المستخدم (online أو offline)
        $user_status = $user->online_offline === 'online';

        // إذا تم الجلب بنجاح
        return response()->json([
            'status' => true,
            'accounts' => $accounts,
            'user_status' => $user_status,
        ], 200);

    } catch (\Exception $e) {
        // التعامل مع الأخطاء الغير متوقعة
        return response()->json([
            'status' => false,
            'error' => 'Failed to retrieve accounts: ' . $e->getMessage(),
        ], 500);
    }
}

      public function updateAccountNumbers(Request $request)
    {
        try {
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