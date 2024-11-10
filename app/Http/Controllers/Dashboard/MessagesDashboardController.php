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
        $chat = Chat::where('id', $id)->first();
        if (!$id) {
           return response()->json([
               'status' => false,
               'error' => 'chat_id is required'
           ], 400);
        }
        $messages = Message::where('chat_id', $id)->orderBy('created_at', 'desc') ->get();
        foreach ($messages as $message) {
                if (is_null($message->readed_at) && $message->user_id === $chat->user_id) {
                    $message->readed_at = now();
                    $message->save();
                }
            }   
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
       if ($request->hasFile('message')) {
            $file = $request->file('message');
            if ($file->isValid()) {
                $name = strtolower(Str::random(10)) . '-' . str_replace([' ', '_'], '-', $file->getClientOriginalName());
                $destinationPath = public_path('images/chat_files/');
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }
                $file->move($destinationPath, $name);
                Message::create([
                    'message' =>  "https://aquan.aquan.website/api/show/image/chat_files/$name",
                    'user_id' => $user->id,
                    'chat_id' => $chat->id,
                    'is_file' => 'yes',
                    'file_name' => $name,
                    'file_original_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientOriginalExtension(),
                    
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Uploaded file is not valid',
                ], 400);
            }
        } else {
            $messageText = $request->input('message');
            if (empty($messageText)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Message text is required',
                ], 400);
            }
            Message::create([
                'message' => $messageText,
                'user_id' => $user->id,
                'chat_id' => $chat->id,
            ]);
        }
        $chat->load('messages');
        return response()->json([
            'status' => true,
            'messages' =>$chat->messages,
        ]);
    }
}