<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    public function create()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return view('conversations.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $sender_id = auth()->id();
        $recipient_id = $request->recipient_id;

        // Vérifier si une conversation existe déjà entre ces deux utilisateurs
        $conversation = Conversation::where(function ($query) use ($sender_id, $recipient_id) {
            $query->where('user_one', $sender_id)
                  ->where('user_two', $recipient_id);
        })->orWhere(function ($query) use ($sender_id, $recipient_id) {
            $query->where('user_one', $recipient_id)
                  ->where('user_two', $sender_id);
        })->first();

        // Si aucune conversation n'existe, en créer une
        if (!$conversation) {
            $conversation = Conversation::create([
                'user_one' => $sender_id,
                'user_two' => $recipient_id,
            ]);
        }

        // Ajouter le premier message
        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $sender_id,
            'content' => $request->message,
        ]);

        return redirect()->route('conversations.show', $conversation->id);
    }

    public function index()
    {
        $conversations = Conversation::where('user_one', Auth::id())
                        ->orWhere('user_two', Auth::id())
                        ->with(['userOne', 'userTwo']) // Assure-toi d'avoir bien défini ces relations
                        ->get();
    
        return view('conversations.index', compact('conversations'));
    }
    

    public function show($conversationId)
    {
        // Récupérer la conversation et ses messages
        $conversation = Conversation::findOrFail($conversationId);
        $messages = $conversation->messages()->latest()->get(); // Récupère tous les messages de la conversation
    
        // Retourner la vue avec les messages
        return view('conversations.show', compact('conversation', 'messages'));
    }
    
}
