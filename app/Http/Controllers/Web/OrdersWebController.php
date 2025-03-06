<?php

namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;

class OrdersWebController extends Controller
{
    protected function get(Request $request)
    {
        $client_id = $request->query('client_id');
        if (!$client_id) {
            return response()->json(['message' => 'client_id مطلوب'], 400);
        }
        $orders = Order::where('client_id', $client_id)->get();
        return response()->json($orders, 200);
    }

}
