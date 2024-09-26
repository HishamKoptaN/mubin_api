<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
   
    public function handleNotifications(Request $request)
    {
        switch ($request->method()) {
            case 'GET':
                return $this->getNotifications($request);
            case 'POST':
                return $this->store($request);
            case 'PUT':
                return $this->updateFile($request);
            case 'DELETE':
                return $this->deleteFile($request);
            default:
                return response()->json(['status' => false, 'message' => 'Invalid request method'], 405);
        }
    }
    public function getNotifications(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'error' => __('User not authenticated')
            ], 401);
        }
        $userId = $user->id;
        $notifications = Notification::where('type', 'public')
            ->where(function ($query) use ($userId) {
                $query->whereJsonContains('notifiable_id', $userId);
            })
            ->latest()
            ->get();
        return response()->json([
            'status' => true,
            'notifications' => $notifications
        ]);
    }
}
