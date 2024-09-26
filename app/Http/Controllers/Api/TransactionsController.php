<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transfer;

class TransactionsController extends Controller
{
    public function handleTransactions(Request $request)
    {
        switch ($request->method()) {
            case 'GET':
                return $this->getUserTransfers($request);
            default:
                return response()->json(['status' => false, 'message' => 'Invalid request method']);
        }
    }

    public function getUserTransfers(Request $request)
    {
    if (!Auth::guard('sanctum')->check()) {
        return response()->json([
            'status' => false,
            'message' => 'User not authenticated'
        ], 401);
    }
    $user = Auth::guard('sanctum')->user();
    $transfers = Transfer::with([
        'senderCurrency:id,name',
        'receiverCurrency:id,name'
    ])->where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
    if ($transfers->isEmpty()) {
        return response()->json([
            'status' => false,
            'message' => 'No transfers found'
        ], 404);
    }
    $transfers->each(function ($transfer) {
        $transfer->senderCurrency->makeHidden(['id']);
        $transfer->receiverCurrency->makeHidden(['id']);
    });
    return response()->json([
        'status' => true,
        'transfers' => $transfers
    ], 200);
}

}
