<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Account;
use App\Models\User;

class PlansDashboardController extends Controller
{
     public function handlePlans(Request $request,$id = null)
    {
        switch ($request->method()) {
              case 'GET':
                return $this->getPlans($request);
            case 'PATCH':
                return $this->updatePlan($request,$id);
            case 'PUT':
                return $this->createPlan($request);
            case 'DELETE':
                return $this->deletePlan($request);
            default:
                return response()->json(['status' => false, 'message' => 'Invalid request method']);
        }
    }
    protected function getPlans()
    {
        $plans = Plan::all();
        $plans_admin = DB::table('user_has_roles')
            ->join('users', 'user_has_roles.user_id', '=', 'users.id')
            ->where('user_has_roles.role_id', 3)
            ->select('users.*')
            ->first();
        $accounts = Account::where('user_id', $plans_admin->id)
                    ->with('currency:id,name') 
                    ->get();
                $accounts->each(function ($account) {
                    $account->currency->makeHidden(['id']);
                });    
        return response()->json([
            'status' => true,
            'plans' => $plans, 
            'accounts' => $accounts
            ]);
    }  
    protected function updatePlan(Request $request, $id)
    {
        try {
            $request->validate([
                "name"                   => "string",
                "amount"                 => "string",
                "discount"               => "string",
                "daily_transfer_count"   => "string",
                "monthly_transfer_count" => "string",
            ]);
            $plan = Plan::findOrFail($id);
                $plan->update([
                "name"                   => $request->name,
                "amount"                 => $request->amount,
                "discount"                  => $request->discount,
                "daily_transfer_count"          => $request->daily_transfer_count,
                "monthly_transfer_count"   => $request->monthly_transfer_count,
                "max_transfer_count" => $request->max_transfer_count,
            ]);
            return response()->json([
                'status' => true,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => __('Plan not found'),
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('Failed to update plan'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    protected function deletePlan(Request $request)
    {
       try {
            $id = $request->input('id');
            $plan = Plan::findOrFail($id);
            $plan->delete();
            return response()->json([
                'status' => true,
                'message' => __('Plan deleted successfully'),
            ], 200);
             } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => __('Plan not found'),
            ], 404);
             } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('Failed to delete plan'),
                'error' => $e->getMessage(),
            ], 500);
       }
    } 
 
    protected function createPlan(Request $request)
    {
          $request->validate([
             "name" => "required|string|max:100",
             "amount" => "required|numeric|between:0,5000",
             "daily_transfer_count" => "required|numeric|min:1",
             "monthly_transfer_count" => "required|numeric|min:1",
         ]);
         
         try {
               $plan = Plan::create([
                 "name" => $request->name,
                 "amount" => $request->amount,
                 "user_amount_per_referal" => 0,
                 "refered_amount" => 0,
                 "amount_after_count" => 0,
                 "count" => 0,
                 "discount" => 0,
                 "discount_type" => 0,
                 "daily_transfer_count" => $request->daily_transfer_count,
                 "monthly_transfer_count" => $request->monthly_transfer_count,
             ]);
             return response()->json([
                 'status' => true,
                 ], 200);
      
           } catch (\Exception $e) {
              return response()->json([
            'status' => false,
            'error' => $e->getMessage(),
            ], 500);
         }
    }
}


// class PlanDashboardController extends Controller
// {
//     use ApiResponseTrait;
//     public function index()
//     {
//         $plansFromDB = PlanResource::collection(Plan::get());

//         if ($plansFromDB) {
//             return  $this->apiResponse($plansFromDB, 'ok', 200);
//         }

//         return  $this->apiResponse(null, 'Not found', 404);
//     }
//     public function Show($id)
//     {
//         $planFromDB = new PlanResource(Plan::find($id));
//         if ($planFromDB) {
//             return  $this->apiResponse(new PlanResource($planFromDB), 'ok', 200);
//         }
//         return  $this->apiResponse(null, 'Not found', 404);
//     }
//     // public function store($request)
//     // {
//     //     $plan = Plan::create($request);

//     //     if ($plan) {
//     //         return  $this->apiResponse(new PlanResource($plan), 'The Plan Saved', 201);
//     //     }
//     //     return  $this->apiResponse(null, 'The Plan Not Saved', 400);
//     // }
//     public function store(Request $request)
//     {
//         // $this->authorize('create plan');
//         $request->validate([
//             "name" => "required|string|max:100",
//             "amount" => "required|numeric|between:0,5000",
//             "daily_transfer_count" => "required|numeric|min:1",
//             "monthly_transfer_count" => "required|numeric|min:1",
//             "selling_price" => "required|numeric|min:1",
//             "buying_price" => "required|numeric|min:1",
//         ]);
//         $plan = Plan::create([
//             "name" => $request->name,
//             "amount" => $request->amount,
//             "user_amount_per_referal" => 0,
//             "refered_amount" => 0,
//             "amount_after_count" => 0,
//             "count" => 0,
//             "discount" => 0,
//             "discount_type" => 0,
//             "daily_transfer_count" => $request->daily_transfer_count,
//             "monthly_transfer_count" => $request->monthly_transfer_count,
//             "selling_price" => $request->selling_price,
//             "buying_price" => $request->buying_price,
//         ]);
//         return response()->json([
//             'status' => true,
//             'message' => __('Plan created successfully'),
//         ]);
//     }
// }
