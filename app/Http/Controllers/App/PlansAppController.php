<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\Plan;
use App\Traits\ApiResponseTrait;
use App\Models\PlanInvoice;
use App\Models\Rate;
use App\Models\User;
use App\Models\Account;

class PlansAppController extends Controller
{
    use ApiResponseTrait;

    public function handleRequest(
        Request $request,
        $id = null,
    ) {
        switch ($request->method()) {
            case 'GET':
                return $this->get(
                    $request,
                );
            case 'POST':
                return $this->proofPlan(
                    $request,
                    $id,
                );
            default:
                return $this->failureResponse();
        }
    }
    protected function get()
    {
        try {
            $plans = Plan::all();
            return $this->successResponse(
                $plans,
            );
        } catch (\Exception $e) {
            return $this->failureResponse(
                $e->getMessage(),
            );
        }
    }

    public function getPlansRates(
        Request $request,
    ) {
        try {
            $user = Auth::guard('sanctum')->user();
            $employee = User::findOnlineEmployee();
            $to_binance_rates = Rate::getToBinanceRates(
                $user->plan_id,
            );
            if ($employee) {
                $accounts = Account::where(
                    'user_id',
                    $employee->id,
                )
                    ->with(
                        'currency:id,name',
                    )
                    ->get()
                    ->each(
                        fn($account) => $account->currency->makeHidden(
                            ['id'],
                        ),
                    );
            }
            return $this->successResponse(
                [
                    'status' => true,
                    'user_plan' => $user->plan_id,
                    'employee_id' => $employee->id,
                    'account_info' => $accounts,
                    'to_binance_rates' => $to_binance_rates,
                ],
            );
        } catch (\Exception $e) {
            return $this->failureResponse(
                $e->getMessage(),
            );
        }
    }

    protected function proofPlan(
        Request $request,
        $id,
    ) {
        try {
            $user = Auth::guard('sanctum')->user();
            $image = $request->file('image');
            if ($image instanceof \Illuminate\Http\UploadedFile) {
                $name = time() . '_' . $image->getClientOriginalName();
                $destinationPath = public_path('images/plans_invoices/');
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
                $plan = Plan::find($id);
                PlanInvoice::create(
                    [
                        'user_id' => $user->id,
                        'plan_invoice_id' => $id,
                        'image' => "https://aquan.aquan.website/api/show/image/plans_invoices/$name",
                        'method' => $request->method,
                        'amount' => $plan->amount,
                    ],
                );
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
