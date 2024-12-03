<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dash\AccountsDashController;
use App\Http\Controllers\Dash\PlansInvoicesDashController;
use App\Http\Controllers\Dash\PlansDashController;
use App\Http\Controllers\Dash\WithdrawsDashController;
use App\Http\Controllers\Dash\DepositsDashController;
use App\Http\Controllers\Dash\TasksDashController;
use App\Http\Controllers\Dash\MainDashController;
use App\Http\Controllers\Dash\TransfersDashController;
use App\Http\Controllers\Dash\SupportDashController;
use App\Http\Controllers\Dash\MessagesDashController;
use App\Http\Controllers\Dash\RatesDashController;
use App\Http\Controllers\Dash\AppControllerDashController;
use App\Http\Controllers\Dash\NotificationsDashController;
use App\Http\Controllers\Dash\UsersDashController;
use App\Http\Controllers\Dash\PermissionsDashController;
use App\Http\Controllers\Dash\TaskProofsDashController;
use App\Http\Controllers\Dash\ProfileDashController;

Route::any(
    '/main',
    [
        MainDashController::class,
        'handleMain',
    ],
);
Route::get(
    '/permissions',
    [
        PermissionsDashController::class,
        'handlePermissions',
    ],
);
Route::any(
    '/accounts',
    [
        AccountsDashController::class,
        'handleRequest',
    ],
);
Route::any(
    '/plans/{id?}',
    [
        PlansDashController::class,
        'handleRequest',
    ],
);
Route::any(
    '/deposits/{id?}',
    [
        DepositsDashController::class,
        'handleRequest',
    ],
);
Route::any(
    '/withdraws/{id?}',
    [
        WithdrawsDashController::class,
        'handleRequest',
    ],
);
Route::any(
    '/transfers/{id?}',
    [
        TransfersDashController::class,
        'handleRequest',
    ],
);
Route::any(
    '/plansInvoices/{id?}',
    [
        PlansInvoicesDashController::class,
        'handleRequest',
    ],
);
Route::any(
    '/tasks/{id?}',
    [
        TasksDashController::class,
        'handleRequest',
    ],
);

Route::any(
    '/controller/{id?}',
    [
        AppControllerDashController::class,
        'handleRequest',
    ],
);
Route::any(
    '/notifications',
    [
        NotificationsDashController::class,
        'handleRequest',
    ],
);
Route::any(
    '/users',
    [
        UsersDashController::class,
        'handleRequest',
    ],
);
Route::any(
    '/rates',
    [
        RatesDashController::class,
        'handleRequest',
    ],
);
Route::any(
    '/support/{id?}',
    [
        SupportDashController::class,
        'handleRequest',
    ],
);
Route::any(
    '/task-proofs/{id?}',
    [
        TaskProofsDashController::class,
        'handleRequest',
    ],
);
Route::any(
    '/profile',
    [
        ProfileDashController::class,
        'handleRequest',
    ],
);
Route::get(
    '/test',
    function () {
        return "test dash";
    },
);
