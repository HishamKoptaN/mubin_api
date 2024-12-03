<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transfer;
use App\Traits\ApiResponseTrait;


class TransactionsAppController extends Controller
{
    use ApiResponseTrait;
    public function handleRequest(Request $request)
    {
        switch ($request->method()) {
            case 'GET':
                return $this->get(
                    $request,
                );
            default:
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Invalid request method',
                    ],
                );
        }
    }

    public function get(Request $request)
    {
        try {
            if (!Auth::guard('sanctum')->check()) {
                return $this->failureResponse(
                    'User not authenticated',
                    401,
                );
            }
            $user = Auth::guard('sanctum')->user();
            $transfers = Transfer::with([
                'senderCurrency:id,name',
                'receiverCurrency:id,name'
            ])->where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
            if ($transfers->isEmpty()) {
                return $this->failureResponse(
                    'No transfers found',
                    404,
                );
            }
            $transfers->each(
                function ($transfer) {
                    $transfer->senderCurrency->makeHidden(['id']);
                    $transfer->receiverCurrency->makeHidden(['id']);
                },
            );
            return $this->successResponse(
                $transfers,
            );
        } catch (\Exception $e) {
            return $this->failureResponse(
                $e->getMessage(),
            );
        }
    }
}
