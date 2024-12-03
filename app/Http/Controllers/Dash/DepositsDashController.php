<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Deposit;
use App\Models\User;
use App\Traits\ApiResponseTrait;

class DepositsDashController extends Controller
{

    use ApiResponseTrait;
    public function handleRequest(Request $request, $id = null)
    {
        switch ($request->method()) {
            case 'GET':
                return $this->get();
            case 'PATCH':
                return $this->patch(
                    $request,
                    $id,
                );
            default:
                return $this->failureResponse();
        }
    }
    public function get()
    {
        try {
            $deposits = Deposit::with(
                [
                    'user',
                    'employee:id,name',
                    'currency:id,name'
                ],
            )->orderBy('created_at', 'desc')->get();
            $deposits->each(
                function ($deposit) {
                    $deposit->user->makeHidden(['id']);
                    $deposit->currency->makeHidden(['id']);
                    $deposit->employee->makeHidden(['id']);
                },
            );
            return $this->successResponse(
                $deposits,
            );
        } catch (\Exception $e) {
            return $this->failureResponse(
                'حدث خطأ أثناء جلب بيانات الإيداع: ' . $e->getMessage(),
            );
        }
    }
    public function patch(
        Request $request,
        $id,
    ) {
        $request->validate(
            [
                'status' => 'required|in:accepted,rejected',
            ],
        );
        try {
            $deposit = Deposit::find(
                $request->id,
            );
            $deposit->status = $request->status;
            $deposit->save();
            if (
                $request->status === 'accepted'
            ) {
                $user = User::find(
                    $deposit->user_id,

                );
                if ($user) {
                    $user->balance += $deposit->amount;
                    $user->save();
                }
            }
            return $this->successResponse(
                $deposit,
            );
        } catch (\Exception $e) {
            return $this->failureResponse(
                $e->getMessage()
            );
        }
    }
}
