<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrdersDashController extends Controller
{

    public function handleOrders(
        Request $request,
        $branch_id,
    ) {
        switch ($request->method()) {
            case 'GET':
                return $this->getOrders(
                    $request,
                    $branch_id,
                );
            case 'POST':
                return $this->uploadFile(
                    $request,
                );
            case 'PUT':
                return $this->updateFile(
                    $request,
                );
            case 'PATCH':
                return $this->updateUser(
                    $request,
                    $request->id,
                );
            case 'DELETE':
                return $this->deleteFile(
                    $request,
                );
            default:
                return response()->json();
        }
    }

    protected function getOrders(
        Request $request,
        $branch_id,
    ) {
        $orders = Order::where(
            'branch_id',
            $branch_id,
        )->get();
        return response()->json([
            'status' => true,
            'orders' => $orders,
        ], 200);
    }
}
