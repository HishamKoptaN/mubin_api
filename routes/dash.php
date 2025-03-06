<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dash\RolesDashController;
use App\Http\Controllers\Dash\PermissionsDashController;
use App\Http\Controllers\Dash\ProfileDashController;
use App\Http\Controllers\Dash\OrdersDashController;
use App\Http\Controllers\Dash\ClientsDashController;

Route::any(
    '/clients',
    [
        ClientsDashController::class,
        'handleReq',
    ],
);
Route::get(
    '/orders/{client_id?}',
    [
        OrdersDashController::class,
        'getOrders',
    ],
);
Route::any(
    '/roles/{id?}',
    [
        RolesDashController::class,
        'handleRequest',
    ],
);
Route::any(
    '/permissions/{id?}',
    [
        PermissionsDashController::class,
        'handleRequest',
    ],
);
Route::get(
    '/test',
    function () {
        return "test dash";
    },
);
