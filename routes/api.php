<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrdersApiController;
use App\Http\Controllers\Web\OrdersWebController;
Route::post('/upload-image', [OrdersApiController::class, 'uploadImage']);
Route::get(
    '/client-orders/{client_id?}',
    [
        OrdersWebController::class,
        'get',
    ],
);
Route::any(
    '/orders',
    [
        OrdersApiController::class,
        'handleOrders',
    ],
);
Route::any(
    '/orders',
    [
        OrdersApiController::class,
        'handleOrders',
    ],
);
Route::post(
    '/upload',
    [
        OrdersApiController::class,
        'upload',
    ],
);
Route::get(
    '/test',
    function () {
        return "test api mubin";
    },
);
