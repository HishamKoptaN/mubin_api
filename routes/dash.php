<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dash\RolesDashController;
use App\Http\Controllers\Dash\PermissionsDashController;
use App\Http\Controllers\Dash\ProfileDashController;
use App\Http\Controllers\Dash\OrdersDashController;

Route::any(
    '/orders',
    [
        OrdersDashController::class,
        'handleOrders',
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
        return "test dash mubin";
    },
);
