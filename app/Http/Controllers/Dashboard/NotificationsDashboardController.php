<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationsDashboardController extends Controller
{
    public function handleNotifications(Request $request)
    {
        switch ($request->method()) {
            case 'GET':
                return $this->getNotifications();
            case 'POST':
                return $this->createNotification($request);
            case 'PUT':
                return $this->updateFile($request);
            case 'DELETE':
                return $this->deleteFile($request);
            default:
                return response()->json(['status' => false, 'message' => 'Invalid request method']);
        }
    }

    protected function getNotifications()
    {
        $notifications = Notification::orderBy('created_at', 'desc')->get();
        return response()->json(['status' => true, 'notifications' => $notifications]);
    }
    
    public function createNotification(Request $request)
    {
        $notificationData = [
            'type' => $request->input('type', 'public'),
            'message' =>$request->message,
            'notifiable_id' => json_encode($request->input('notifiable_id', [])),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    
        $notification = Notification::create($notificationData);
    
        return response()->json([
            'status' => true,
        ], 200);
    }

}

