<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponseTrait;

class NotificationsAppController extends Controller
{
    use ApiResponseTrait;
    public function handleRequest(Request $request)
    {
        switch ($request->method()) {
            case 'GET':
                return $this->getNotifications(
                    $request,
                );
            case 'POST':
                return $this->store(
                    $request,
                );
            case 'PUT':
                return $this->updateFile(
                    $request,
                );
            case 'DELETE':
                return $this->deleteFile(
                    $request,
                );
            default:
                return $this->failureResponse();
        }
    }
    public function get() {}
    public function getNotifications(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return $this->failureResponse(
                [
                    __('User not authenticated'),
                    401
                ],
            );
        }
        $userId = $user->id;
        $notifications = Notification::where('type', 'public')
            ->where(
                function ($query) use ($userId) {
                    $query->whereJsonContains(
                        'notifiable_id',
                        $userId,
                    );
                },
            )
            ->latest()
            ->get();
        return $this->successResponse(
            $notifications,
        );
    }
}
