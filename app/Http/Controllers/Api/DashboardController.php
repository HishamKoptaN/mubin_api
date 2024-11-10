<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transfer;
use App\Models\Currency;
use App\Models\User;
use App\Models\Rate;
use App\Models\Plan;

class DashboardController extends Controller
{
    public function handleDashboard(Request $request)
    {
        switch ($request->method()) {
            case 'GET':
                return $this->getDashboard($request);
            case 'PATCH':
                return $this->updatewithdraw($request,$id);
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
    public function getDashboard(Request $request)
    {
       try {
           $user = Auth::guard('sanctum')->user();
           if (!$user) {
               return response()->json([
                   'status' => false,
                   'message' => 'User not authenticated',
               ], 401);
           }
           $plan = Plan::where('id', $user->plan_id)->first();     
           $userData = $user->only(['id', 'name', 'image', 'balance', 'plan_id', 'account_number']);
           $transfers = Transfer::with(['receiverCurrency:id,name'])->where('user_id', $user->id)->latest()->limit(2)->get();
           $transfers->each(function ($transfer) {
                   $transfer->receiverCurrency->makeHidden(['id']);
           });
           $exchange_rates = Currency::where('id', '!=', 2)->get();
           $commission = $plan->transfer_commission; 
           $selling_rates = Rate::where([['plan_id', $user->plan_id],['to',2]])->get()
               ->map(function ($selling_price) {
                   return [
                       'price' => $selling_price->price,
                       'updated_at' => $selling_price->updated_at,
                       'from' => $selling_price->fromCurrency->id,
                   ];
               });
           $buying_rates = Rate::where([['plan_id', $user->plan_id], ['from', 2]])->get()
              ->map(function ($buying_price) {
                  return [
                      'price' => $buying_price->price,
                      'updated_at' => $buying_price->updated_at,
                      'to' => $buying_price->toCurrency->id,
                  ];
           });
           $currencies = Currency::all();
           $rates = Rate::where('plan_id',$user->plan_id)->get();
           return response()->json([
               'status' => true,
               'user' => $userData,
               'transfers' => $transfers,
               'exchange_rates' => $exchange_rates,
               'selling_prices' => $selling_rates,
               'buying_prices' => $buying_rates,
               'currencies' => $currencies,
               'rates' => $rates,
               'plan' => $plan, 
               'commission' => $commission,
           ], 200);
       } catch (\Exception $e) {
           return response()->json([
               'status' => false,
               'error' => $e->getMessage(),
           ], 500);
       }
   }
}