<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlanInvoice;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Plan;

class PlansInvoicesDashboardController extends Controller
{
    public function handlePlansInvoices(Request $request,$id = null)
    {
        switch ($request->method()) {
            case 'GET':
                return $this->getPlansInvoices($request);
            case 'PATCH':
                return $this->updatePlansInvoices($request,$id);
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
  public function getPlansInvoices(Request $request)
{
    try {
        $plansInvoices = PlanInvoice::with([
            'user:id,name,account_number',
            'currency:id,name'
        ])
        ->orderBy('created_at', 'desc')
        ->get();
        $plansInvoices->each(function ($planInvoice) {
            if ($planInvoice->user) {
                $planInvoice->user->makeHidden(['id']);
                $planInvoice->currency->makeHidden(['id']);
            }
        });
        return response()->json([
            'status' => true,
            'plans_invoices' => $plansInvoices
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'حدث خطأ أثناء جلب بيانات الفواتير: ' . $e->getMessage()
        ], 500);
    }
}

    public function updatePlansInvoices(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected',
            'user_id' => 'required_if:status,accepted|exists:users,id',
            'new_plan_id' => 'required_if:status,accepted|exists:plans,id',
        ]);
        try {
            DB::beginTransaction();
            $planInvoice = PlanInvoice::find($id);
            if (!$planInvoice) {
                return response()->json([
                    'status' => false,
                    'message' => 'Plan Invoice not found',
                ], 404);
            }
            $planInvoice->status = $request->status;
            if ($request->status === 'accepted') {
                $user = User::find($request->user_id);
                if (!$user) {
                    return response()->json([
                        'status' => false,
                        'message' => 'User not found',
                    ], 404);
                }
                $plan = Plan::find($request->new_plan_id);
                if (!$plan) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Plan not found',
                    ], 404);
                }
                $user->plan_id = $request->new_plan_id;
                $user->save();
            }
            $planInvoice->save();
            DB::commit();
            return response()->json([
                'status' => true,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'حدث خطأ: ' . $e->getMessage(),
            ], 500);
        }
    }
}