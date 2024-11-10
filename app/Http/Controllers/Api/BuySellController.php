<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\DashController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Account;
use App\Models\Currency;
use App\Models\Transfer;
use App\Models\User;
use App\Models\Plan; 
use App\Models\Rate;
class BuySellController extends Controller
{   
    public function handleBuySell(Request $request,$id = null)
    {
        switch ($request->method()) {
           case 'GET':
            if ($id === null) {
                return $this->getBuySell($request);
            } else {
                return $this->getReceivedAccount($request, $id);
            }
            case 'POST':
                return $this->store($request);   
            default:
                return response()->json(['status' => false, 'error' => 'Invalid request method']);
        }
    }
    public function getBuySell(Request $request)
    {   
        try {
            $user = Auth::guard('sanctum')->user();  
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'error' => 'User not authenticated',
                ], 401);
            }
            $dashController = DashController::findOrFail(1); 
            $buy_sell_status = (bool) $dashController->status; 
            $buy_sell_message = $dashController->message;
            $total_monthly_transfers = Transfer::where('user_id', $user->id)->whereMonth('created_at', Carbon::now()->month)->sum('amount');
            $total_daily_transfers = Transfer::where('user_id',  $user->id)->whereDate('created_at', Carbon::today())->sum('amount');
            $user_plan_id = $user->plan_id;
            $max_transfer_count = Plan::where('id', $user_plan_id)->value('max_transfer_count');
            $monthly_transfer_count = Plan::where('id', $user_plan_id)->value('monthly_transfer_count');
            $daily_transfer_count = Plan::where('id', $user_plan_id)->value('daily_transfer_count');
            $currencies = Currency::select('id', 'name','name_code', 'comment')->get();
            $accounts = Account::with('currency:id,name')->where('user_id', $user->id)->get(); 
            $rates = Rate::where('plan_id', $user_plan_id)->get();
            
            return response()->json([
                'status' => true,
                'buy_sell_status' => $buy_sell_status,
                'buy_sell_message' => $buy_sell_message,
                'total_monthly_transfers' => $total_monthly_transfers,  
                'total_daily_transfers' => $total_daily_transfers,
                'user_plan_id' => $user_plan_id,
                'max_transfer_count' => $max_transfer_count,
                'monthly_transfer_count' => $monthly_transfer_count,
                'daily_transfer_count' => $daily_transfer_count,
                'currencies' => $currencies,                
                'rates' => $rates,
                'accounts' => $accounts,
              
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }
    public function getReceivedAccount(Request $request,$id){
        $employee = DB::table('user_has_roles')
            ->join('users', 'user_has_roles.user_id', '=', 'users.id')
            ->where('user_has_roles.role_id', 4)
            ->select('users.*')
            ->first();    
       $account = Account::where('user_id', $employee->id)
                   ->where('bank_id', $id)
                   ->with('currency:id,name')
                   ->first();
                   
        return response()->json([
            'status' => true,
            'account' =>$account,
        ]);           
    }
    public function store(Request $request)
    {
        try {
            $user = Auth::guard('sanctum')->user();
            $image = $request->file('image');
            if ($image instanceof \Illuminate\Http\UploadedFile) {
                $name = time() . '_' . $image->getClientOriginalName();
                $destinationPath = public_path('images/transfers/');
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
                Transfer::create([
                    'user_id' => $user->id,
                    'sender_currency_id' => $request->sender_currency_id,
                    'receiver_currency_id' => $request->receiver_currency_id,
                    'amount' => $request->amount,
                    'net_amount' => $request->net_amount,
                    'rate' => $request->rate,
                    'receiver_account' => $request->receiver_account,                    
                    'employee_id' => $request->employee_id,
                    'image' => "https://aquan.aquan.website/api/show/image/transfers/$name",
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