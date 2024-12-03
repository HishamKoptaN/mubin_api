<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlanInvoice;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Plan;
use App\Traits\ApiResponseTrait;

class PlansInvoicesDashController extends Controller
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
            case 'PATCH':
                return $this->patch(
                    $request,
                    $id,
                );
                return $this->failureResponse();
        }
    }
    public function get()
    {
        try {
            $plansInvoices = PlanInvoice::with(
                [
                    'user:id,name,account_number',
                    'currency:id,name'
                ],
            )
                ->orderBy(
                    'created_at',
                    'desc',
                )
                ->get();
            $plansInvoices->each(
                function ($planInvoice) {
                    if ($planInvoice->user) {
                        $planInvoice->user->makeHidden(
                            [
                                'id',
                            ],
                        );
                        $planInvoice->currency->makeHidden(
                            [
                                'id',
                            ],
                        );
                    }
                },
            );
            return $this->successResponse(
                $plansInvoices,
            );
        } catch (\Exception $e) {
            return $this->failureResponse(
                'حدث خطأ أثناء جلب بيانات الفواتير: ' . $e->getMessage(),
            );
        }
    }

    public function patch(
        Request $request,
    ) {
        $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        try {
            // بدء المعاملة
            DB::beginTransaction();
            // جلب الفاتورة
            $planInvoice = PlanInvoice::with(['user:id,name,account_number', 'currency:id,name'])
                ->find(
                    $request->id,
                );
            if (!$planInvoice) {
                return $this->failureResponse('الفاتورة غير موجودة.');
            }
            // تحديث حالة الفاتورة
            $planInvoice->status = $request->status;
            if ($request->status === 'accepted') {
                // جلب المستخدم المرتبط بالفاتورة
                $user = User::find($planInvoice->user_id);
                if (!$user) {
                    throw new \Exception('المستخدم المرتبط غير موجود.');
                }

                // تحديث خطة المستخدم
                $user->plan_id = $planInvoice->plan_invoice_id;
                $user->save();
            }
            // حفظ الفاتورة
            $planInvoice->save();
            // إخفاء الحقول غير الضرورية
            if ($planInvoice->user) {
                $planInvoice->user->makeHidden(['id']);
            }
            if ($planInvoice->currency) {
                $planInvoice->currency->makeHidden(['id']);
            }
            // إنهاء المعاملة
            DB::commit();
            // إرجاع الفاتورة مع التفاصيل
            return $this->successResponse($planInvoice);
        } catch (\Exception $e) {
            // التراجع عن التغييرات
            DB::rollBack();
            return $this->failureResponse('حدث خطأ: ' . $e->getMessage());
        }
    }
}
