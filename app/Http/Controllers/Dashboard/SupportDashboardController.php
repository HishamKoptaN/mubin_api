<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;
use App\Models\User;

class SupportDashboardController extends Controller
{
    public function handleSupport(Request $request)
    {
        switch ($request->method()) {
            case 'GET':
                return $this->getChats($request);
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
protected function getChats(Request $request)
{
    $chats = Chat::with(['user:id,name,image'])
        ->withCount(['messages as unread_messages_count' => function ($query) {
            $query->whereNull('readed_at')
                  ->whereColumn('messages.user_id', '!=', 'chats.user_id'); // التأكد من أن user_id للرسالة لا يساوي user_id للمحادثة
        }])
        ->orderBy('created_at', 'asc')
        ->get();

    $chats->each(function ($chat) {
        $chat->user->makeHidden(['id']);
    });

    if ($chats->isEmpty()) {
        return response()->json([
            'status' => false,
            'message' => 'No chats found',
        ], 404);
    }

    return response()->json([
        'status' => true,
        'chats' => $chats
    ]);
}

}