<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\App\OrdersAppController;

Route::any(
    '/orders',
    [
        OrdersAppController::class,
        'handleOrders',
    ],
);
Route::get(
    '/test',
    function () {
        return "test app mubin";
    },
);
