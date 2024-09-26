<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Deposit;
use App\Models\User;

class DepositsDashboardController extends Controller
{
   
    public function handleDeposits(Request $request,$id = null)
    {
        switch ($request->method()) {
            case 'GET':
                return $this->getDeposits();
            case 'PATCH':
                return $this->updatedeposit($request,$id);
            case 'POST':
                return $this->uploadFile($request);
            case 'PUT':
                return $this->updateFile($request);
            case 'DELETE':
                return $this->deleteFile($request);
            default:
                return response()->json(['status' => false, 'message' => 'Invalid request method']);
        }
    }
    public function getDeposits()
    {
        try {
            $deposits = Deposit::with([
                'user:id,name,account_number,plan_id',
                'employee:id,name',  
                'currency:id,name' 
            ])->orderBy('created_at', 'desc')->get();
            $deposits->each(function ($deposit) {
                $deposit->user->makeHidden(['id']); 
                $deposit->currency->makeHidden(['id']);
                $deposit->employee->makeHidden(['id']);
            });
            return response()->json([
                'status' => true,
                'deposits' => $deposits
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'حدث خطأ أثناء جلب بيانات الإيداع: ' . $e->getMessage()
            ], 500);
        }
    }
    public function updatedeposit(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);
        try {
            $deposit = Deposit::find($id);
            if (!$deposit) {
                return response()->json([
                    'status' => false,
                    'message' => 'deposit not found',
                ], 404);
            }
            $deposit->status = $request->status;
            $deposit->save();
            if ($request->status === 'accepted') {
            $user = User::find($deposit->user_id);
                if ($user) {
                    $user->balance += $deposit->amount;
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
