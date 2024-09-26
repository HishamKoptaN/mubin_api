<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\Chat;

class MessagesDashboardController extends Controller
{
     public function handleMessages(Request $request,$id = null)
    {
        switch ($request->method()) {
            case 'GET':
                return $this->getMessages($request,$id);
            case 'POST':
                return $this->sendMessage($request,$id);
           
            default:
                return response()->json(['status' => false, 'message' => 'Invalid request method']);
        }
    }
    
    protected function getMessages(Request $request,$id)
    {
        if (!$id) {
           return response()->json([
               'status' => false,
               'error' => 'chat_id is required'
           ], 400);
        }
        $messages = Message::where('chat_id', $id)
           ->orderBy('created_at', 'asc')
           ->get();
    //     if ($messages->isEmpty()) {
    //     // إنشاء محادثة جديدة
    //     $newMessage = Chat::create([
    //         'admin_id' => $user->id,
    //     ]);
    //     $newChat->messages()->create([
    //         'message' => 'Welcome to the chat!',
    //         'user_id' => $user->id,
    //     ]);
        
    //     // إعادة المحادثة الجديدة مع الرسالة الترحيبية
    //     $chats = Chat::with(['user:id,name,image'])
    //                 ->where('admin_id', $user->id)
    //                 ->orderBy('created_at', 'asc')
    //                 ->get();
    //   }   
     
       return response()->json([
           'status' => true,
           'messages' => $messages
       ]);
    }
    
    protected function sendMessage(Request $request,$id)
    {
        $user = Auth::guard('sanctum')->user();
        if (!Auth::guard('sanctum')->check()) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated'
            ], 401);
        }
        $chat = Chat::where('id', $id)->first();
         if (!$chat) {
            $chat = Chat::create([
                'admin_id' => User::where('id', 3)->first()->id ?? null,
                'user_id' => $user->id
            ]);
        }
        $message = Message::firstOrCreate([
            'message' => $request->message,
            'user_id' => $user->id,
            'chat_id' => $id,
        ]);
        $chat->load('messages');
        return response()->json([
            'status' => true,
            'messages' =>$chat->messages,
        ]);
    }
}