<?php

use App\Http\Controllers\Admin\CurrenciesController;
use App\Http\Controllers\Admin\DepositsController;
use App\Http\Controllers\Admin\InvoicesController;
use App\Http\Controllers\Admin\PlansController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\TasksController;
use App\Http\Controllers\Admin\TransfersController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\WithdrawsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Models\Chat;
use App\Models\Invoice;
use App\Models\Message;
use App\Models\Plan;
use App\Models\TaskUser;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware('auth', 'install')->get('/', [HomeController::class, 'index'])->name("/");

Route::middleware('auth', 'install')->group(function () {
    Route::prefix('admin')->as('admin.')->middleware('role:Admin|Manager')->group(function () {
        // Route::match(['get', 'post'], '/roles', [UsersController::class, 'roles'])->name('roles');
        Route::resource('/users', UsersController::class);
        Route::resource('/deposits', DepositsController::class);
        Route::resource('/invoices', InvoicesController::class);
        Route::post('/plans/accept/{id}', [PlansController::class, 'accept'])->name('plans.accept');
        Route::resource('/plans', PlansController::class);
        Route::post('/tasks/accept/{id}', [TasksController::class, 'accept'])->name('tasks.accept');
        Route::resource('/tasks', TasksController::class);
        Route::resource('/transfers', TransfersController::class);
        Route::resource('/withdraws', WithdrawsController::class);
        Route::match(['get', 'post'], '/currencies/rates', [CurrenciesController::class, 'rates'])->name('currencies.rates');
        Route::resource('/currencies', CurrenciesController::class);
        Route::match(['get', 'post'], '/settings', SettingsController::class)->name('settings');
        Route::get('/support/{chat_id?}', [SupportController::class, 'index'])->name('support');
        Route::post('/support/{chat_id}', [SupportController::class, 'create'])->name('support.create');
        Route::post('/support/file/{chat_id}', [SupportController::class, 'file'])->name('support.file');
    });
});


require __DIR__ . '/auth.php';
