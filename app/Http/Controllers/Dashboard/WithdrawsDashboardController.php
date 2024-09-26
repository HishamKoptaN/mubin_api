<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Withdraw;
use App\Models\User;
use App\Models\Chat;

class WithdrawsDashboardController extends Controller
{
    public function handleWithdraws(Request $request,$id = null)
    {
        switch ($request->method()) {
            case 'GET':
                return $this->getWithdraws($request);
            case 'PATCH':
                return $this->updatewithdraw($request,$id);
            default:
                return response()->json(['status' => false, 'message' => 'Invalid request method']);
        }
    }
      public function getWithdraws()
    {
        try {
            $withdraws = Withdraw::with([
                'user:id,name,account_number,plan_id',
                'currency:id,name'
            ])->orderBy('created_at', 'desc')->get();
            $withdraws->each(function ($withdraw) {
                $withdraw->user->makeHidden(['id']);
                $withdraw->currency->makeHidden(['id']);
            });
            return response()->json([
                'status' => true,
                'withdraws' => $withdraws
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'حدث خطأ أثناء جلب بيانات السحب: ' . $e->getMessage()
            ], 500);
        }
    }
   
    public function updatewithdraw(Request $request,$id)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]); 
        try {
            $withdraw = withdraw::find($id);
            if (!$withdraw) {
                return response()->json([
                    'status' => false,
                    'message' => 'withdraw not found',
                ], 404);
            }
            $withdraw->status = $request->status;
            $withdraw->save();  
            if ($request->status === 'accepted') {
            $user = User::find($withdraw->user_id);
                if ($user) {
                    $user->balance -= $withdraw->amount;
                    $user->save();
                }
            }
            return response()->json([
                    'status' => true,
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
    }   
}