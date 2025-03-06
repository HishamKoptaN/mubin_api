<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;
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
    ) {
        $client_id = $request->query(
            'client_id',
        );
        if (!$client_id) {
            return  failureRes(
                'client_id مطلوب',
            );
        }
        $orders = Order::where(
            'client_id',
            $client_id,
        )->paginate(10);
        return successRes(
            paginateRes(
                $orders,
                OrderResource::class,
                'orders',
            )
        );
    }
}
