<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AppControllerModel;
use Illuminate\Http\Request;

class AppControllerDashboardController extends Controller
{
    public function handleController(Request $request, $id = null)
    {
        switch ($request->method()) {
            case 'GET':
                return $this->getController($request);
            case 'PATCH':
                return $this->updateMessage($request, $id);
            case 'PUT':
                return $this->updateController($request, $id);
            case 'DELETE':
                return $this->deleteFile($request);
            default:
                return response()->json(['status' => false, 'message' => 'Invalid request method']);
        }
    }

    protected function getController(Request $request)
    {
        $record = AppControllerModel::first();
        if (!$record) {
            return response()->json([
                'status' => false,
                'message' => 'Record not found'
            ], 404);
        }

        return response()->json([
            'status' => $record->status,
            'message' => $record->message,
        ]);
    }

    protected function updateController(Request $request, $id)
    {
        if (!$id) {
            return response()->json([
                'status' => false,
                'message' => 'ID is required'
            ], 400);
        }

        $controller = AppControllerModel::find($id);

        if (!$controller) {
            return response()->json([
                'status' => false,
                'message' => 'Record not found'
            ], 404);
        }

        $status = $request->input('status');

        if ($status === null) {
            return response()->json([
                'status' => false,
                'message' => 'Status is required'
            ], 400);
        }

        $controller->status = $status;
        $controller->save();

        return response()->json([
            'status' => true,
        ]);
    }

    protected function updateMessage(Request $request, $id)
    {
        $controller = AppControllerModel::find($id);
        if (!$controller) {
            return response()->json([
                'status' => false,
                'message' => 'Record not found'
            ], 404);
        }
        $message = $request->input('message');
        if ($message === null) {
            return response()->json([
                'status' => false,
                'message' => 'Message is required'
            ], 400);
        }
        $controller->message = $message;
        $controller->save();
        return response()->json([
            'status' => true,
            'message' => 'Message updated successfully'
        ]);
    }
}
