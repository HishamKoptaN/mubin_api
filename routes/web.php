<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\OrdersWebController;

Route::get(
    '/orders/{client_id?}',
    [
        OrdersWebController::class,
        'get',
    ],
);
Route::get(
    '/test',
    function () {
        return "test website";
    },
);
