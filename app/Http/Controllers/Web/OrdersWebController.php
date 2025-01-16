<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrdersWebController extends Controller
{

    protected function get(
        $client_id,
    ) {
        $orders = Order::where(
            'client_id',
            $client_id,
        )->get();
        return response()->json(
            $orders,
            200,
        );
    }
}
