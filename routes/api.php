<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\CurrencyTransferController;
use App\Http\Controllers\Dashboard\DashboardSupportController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserPlanController;
//--------------------Auth--------------------//

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\CheckController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginGoogleController;
use App\Http\Controllers\Auth\LoginGoogleCompleteController;
use App\Http\Controllers\Auth\ChangePasswordController;

//--------------------App--------------------//
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\BuySellController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SupportChatController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\DepositController;
use App\Http\Controllers\Api\WithdrawController;
use App\Http\Controllers\Api\AccountsController;
use App\Http\Controllers\Api\DepositsWithdrawsController;
use App\Http\Controllers\Api\NotificationsController;
use App\Http\Controllers\Api\TransferController;
use App\Http\Controllers\Api\TasksController;
use App\Http\Controllers\Api\TransactionsController;
use App\Http\Controllers\Api\PublicController;
use App\Http\Controllers\Api\ReferalsController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\WithdrawsDepositsController;


//--------------------Dashboard--------------------//
use App\Http\Controllers\Dashboard\MainDashboardController;
use App\Http\Controllers\Dashboard\InvoiceController;
use App\Http\Controllers\Dashboard\TasksDashboardController;
use App\Http\Controllers\Dashboard\TransfersDashboardController;
use App\Http\Controllers\Dashboard\SupportDashboardController;
use App\Http\Controllers\Dashboard\MessagesDashboardController;
use App\Http\Controllers\Dashboard\DailyRatesDashboardController;
use App\Http\Controllers\Dashboard\AppControllerDashboardController;
use App\Http\Controllers\Dashboard\AccountsDashboardController;
use App\Http\Controllers\Dashboard\NotificationsDashboardController;
use App\Http\Controllers\Dashboard\UsersDashboardController;
use App\Http\Controllers\Dashboard\PermissionsDashboardController;
use App\Http\Controllers\Dashboard\PermissionAssignmentController;
use App\Http\Controllers\Dashboard\PermissionAndRolesController;
use App\Http\Controllers\Dashboard\PlansDashboardController;
use App\Http\Controllers\Dashboard\UserTasksDashboardController;
use App\Http\Controllers\Dashboard\ProfileDashboardController;
use App\Http\Controllers\Dashboard\DepositsDashboardController;
use App\Http\Controllers\Dashboard\WithdrawsDashboardController;
use App\Http\Controllers\Dashboard\PlansInvoicesDashboardController;

//--------------------Models--------------------//

use App\Models\Currency;
use App\Models\Invoice;
use App\Models\Controller;
use App\Models\Message;
use App\Models\Plan;
use App\Models\Setting;
use App\Models\Task;
use App\Models\User;
use App\Models\Notification;
use App\Models\UsersTasks;
use App\Models\Deposit;
use App\Models\Chat;
use App\Models\Account;

Route::post('/chat', [ChatController::class, 'sendMessage']);
//========================   Auth  ==========================//
Route::post('/login', [LoginController::class, 'login']);
Route::any('/show/image/{file}/{image}', [ImageController::class, 'handleImages']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/check', [CheckController::class, 'check']);
Route::post('/register', [RegisterController::class, 'register']);
//=========================  Api   ==========================//

Route::any('/dashboard', [DashboardController::class, 'handleDashboard']);
Route::any('/profile', [ProfileController::class, 'handleProfile']);
Route::any('/plans/{id?}', [PlanController::class, 'handlePlans']);
Route::any('/plan/rates', [PlanController::class, 'getPlansRates']);
Route::any('/accounts', [AccountsController::class, 'handleAccounts']);
Route::any('/support', [SupportChatController::class, 'handleSupport']);
Route::any('/deposit', [DepositController::class, 'handleDeposit']);
Route::any('/deposit/rates', [DepositController::class, 'geEmployeeAccounts']);
Route::any('/withdraws-deposits', [WithdrawsDepositsController::class, 'handleWithdrawsDeposits']);
Route::any('/withdraw', [WithdrawController::class, 'handleWithdraw']);
Route::any('/withdraw/rates', [WithdrawController::class, 'getWithdrawRates']);
Route::any('/transfer/{account_number?}', [TransferController::class, 'handleTransfer']);
Route::any('/notifications', [NotificationsController::class, 'handleNotifications']);
Route::any('/buy-sell/{id?}', [BuySellController::class, 'handleBuySell']);
Route::any('/tasks/{id?}', [TasksController::class, 'handleTasks']);
Route::get('/task/details/{id}', [TasksController::class, 'getTaskDetails']);
Route::get('/transactions', [TransactionsController::class, 'handleTransactions']);
Route::get('/public', [PublicController::class, 'handlePublic']);
Route::get('/referals', [ReferalsController::class, 'handleReferals']);

//========================  Dashboard ======================//
Route::any('/dashboard/main', [MainDashboardController::class, 'handleMain']);
Route::any('/dashboard/tasks', [TasksDashboardController::class, 'handleTasks']);
Route::any('/dashboard/rates', [DailyRatesDashboardController::class, 'handleDailyRates']);
Route::any('/dashboard/controller/{id?}', [AppControllerDashboardController::class, 'handleController']);
Route::any('/dashboard/accounts', [AccountsDashboardController::class, 'handleAccounts']);
Route::any('/dashboard/notifications', [NotificationsDashboardController::class, 'handleNotifications']);
Route::any('/dashboard/users', [UsersDashboardController::class, 'handleUsers']);
Route::get('/dashboard/permissions', [PermissionsDashboardController::class, 'handlePermissions']);
// Route::get('/dashboard/roles', [RoleController::class, 'index']);
Route::any('/dashboard/plans/{id?}', [PlansDashboardController::class, 'handlePlans']);
Route::any('/dashboard/support', [SupportDashboardController::class, 'handleSupport']);
Route::any('/dashboard/messages/{id?}', [MessagesDashboardController::class, 'handleMessages']);
Route::any('/dashboard/deposits/{id?}', [DepositsDashboardController::class, 'handleDeposits']);
Route::any('/dashboard/withdraws/{id?}', [WithdrawsDashboardController::class, 'handleWithdraws']);
Route::any('/dashboard/plans-invoices/{id?}', [PlansInvoicesDashboardController::class, 'handlePlansInvoices']);
Route::any('/dashboard/transfers/{id?}', [TransfersDashboardController::class, 'handleTransfers']);
Route::any('/dashboard/user-tasks/{id?}', [UserTasksDashboardController::class, 'handleUserTasks']);
Route::any('/dashboard/profile', [ProfileDashboardController::class, 'handleProfile']);

//===========================================================//
Route::get('/settings', function () {
    $plans_admin = User::where('role', 5)
        ->first();
    if (!$plans_admin) {
        return response()->json([
            'status' => false,
            'message' => 'No active employee found'
        ], 404);
    }
    return response()->json([
        'status' => true,
        'account_info ' => $plans_admin->account_info
    ], 200);
});
