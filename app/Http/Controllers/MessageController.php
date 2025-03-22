<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Events\NewMessage;
use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    public function send(Request $request)
    {
        // Validation des entrées
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'message' => 'required|string'
        ]);
    
        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'sender_id' => Auth::id(),
            'message' => $request->message
        ]);
    
        // Diffuser l'événement MessageSent
        broadcast(new MessageSent($message));
    
        return response()->json(['success' => true, 'message' => $message]);
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'conversation_id' => 'required|exists:conversations,id',
    //         'message' => 'required|string|max:500',
    //     ]);

    //     $message = new Message();
    //     $message->conversation_id = $request->conversation_id;
    //     $message->sender_id = auth()->id();
    //     $message->message = $request->message;
    //     $message->save();
    //     dd(Message::latest()->first());

    //     return response()->json(['success' => true, 'message' => $message]);
    // }


}
