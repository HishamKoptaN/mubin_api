<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class TransfersDashboardController extends Controller
{
    public function handleTransfers(Request $request,$id = null)
    {
        switch ($request->method()) {
            case 'GET':
                return $this->getTransfers();
            case 'PATCH':
                return $this->updateTransfer($request,$id);
            case 'POST':
                return $this->uploadFile($request);
            case 'PUT':
                return $this->updateFile($request);
            case 'DELETE':
                return $this->deleteFile($request);
            default:
                return response()->json(['status' => false, 'message' => 'Invalid request method']);
        }
    }
    public function getTransfers()
    {
        $transfers = Transfer::with([
            'user:id,name',
            'employee:id,name',
            'senderCurrency:id,name',
            'receiverCurrency:id,name'
        ])->orderBy('created_at', 'desc')->get();
        $transfers->each(function ($transfer) {
            $transfer->user->makeHidden(['id']);
            $transfer->employee->makeHidden(['id']);
            $transfer->senderCurrency->makeHidden(['id']);
            $transfer->receiverCurrency->makeHidden(['id']);
        });
        return response()->json([
            'status' => true,
            'transfers' => $transfers,
        ]);
    }
    public function updateTransfer(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);
        $transfer = Transfer::find($id);
        if (!$transfer) {
            return response()->json([
                'status' => false,
                'message' => 'Transfer not found',
            ], 404);
        }
        try {
            $transfer->status = $request->input('status');
            $transfer->save();
                return response()->json([
                'status' => true,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
}