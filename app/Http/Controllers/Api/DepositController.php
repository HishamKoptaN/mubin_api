<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\Plan;
use App\Models\Deposit;
use App\Models\User;
use App\Models\Withdraw;
use App\Models\Rate;
use App\Models\Account;

class DepositController extends Controller
{
    public function handleDeposit(Request $request)
    {
        switch ($request->method()) {
            case 'GET':
                return $this->getDeposits($request);
            case 'POST':
                return $this->depositMoney($request);
            default:
                return response()->json(['status' => false, 'message' => 'Invalid request method'], 405);
        }
    }
    public function getDeposits(Request $request)
    {
        if (!Auth::guard('sanctum')->check()) {
            return response()->json([
                'status' => false,
                'error' => __('User not authenticated')
            ], 401);
        }
        $user = Auth::guard('sanctum')->user();
        $deposits = Deposit::with('currency:id,name')
            ->where('user_id', $user->id)->get(); 
        $deposits->each(function ($deposit) {
                    $deposit->currency->makeHidden(['id']);
            });
        return response()->json([
            'status' => true,
            'deposits' => $deposits,
        ]);
    }
    public function geEmployeeAccounts(Request $request)
    {   
        $user = Auth::guard('sanctum')->user();
        $employee = DB::table('user_has_roles')
            ->join('users', 'user_has_roles.user_id', '=', 'users.id')
            ->where('user_has_roles.role_id', 4)
            ->select('users.*')
            ->first();
        $to_binance_rates = Rate::where([
            ['plan_id', $user->plan_id],
            ['to', 1]
        ])->get()->map(function ($rate) {
            return [
                'selling' => $rate->selling,
                'updated_at' => $rate->updated_at,
                'currency_name' => $rate->fromCurrency->name,
                'from' => $rate->fromCurrency->id,
            ];
        });
        if ($employee) {
            if ($employee->online_offline === 'online') {
                $accounts = Account::where('user_id', $employee->id)
                    ->with('currency:id,name') 
                    ->get();
                $accounts->each(function ($account) {
                    $account->currency->makeHidden(['id']);
                });
                return response()->json([
                    'status' => true,
                    'user_plan' => $user->plan_id,
                    'employee_id' => $employee->id,
                    'account_info' => $accounts, 
                    'to_binance_rates' => $to_binance_rates, 
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Employee is offline'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'No employee found with role_id 4'
            ]);
        }
    }
    public function depositMoney(Request $request)
    {
    try {
        $user = Auth::guard('sanctum')->user();
        $image = $request->file('image');
        if ($image instanceof \Illuminate\Http\UploadedFile) {
            $name = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('images/users_tasks/');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $name);
            if (!Auth::guard('sanctum')->check()) {
                return response()->json([
                    'status' => false,
                    'error' => __('User not authenticated')
                ], 401);
            }
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'error' => __('User not authenticated')
                ], 401);
            }
            Deposit::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'image' => "https://aquan.aquan.website/api/show/image/users_tasks/$name",
                'method' => $request->method,
                'employee_id' => $request->employee_id,
            ]);
            return response()->json([
                'status' => true,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'error' => __('No image uploaded or invalid image')
            ], 400);
        }
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'status' => false,
            'error' => $e->errors(),
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'error' => __('An unexpected error occurred: ') . $e->getMessage(),
        ], 500);
    }
  }
}