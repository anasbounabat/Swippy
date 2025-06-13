<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Objet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $conversations = $user->conversations();
        
        // Récupérer le dernier message de chaque conversation
        $conversationsWithLastMessage = [];
        
        foreach ($conversations as $otherUser) {
            $lastMessage = Message::where(function($query) use ($user, $otherUser) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', $otherUser->id);
            })->orWhere(function($query) use ($user, $otherUser) {
                $query->where('sender_id', $otherUser->id)
                      ->where('receiver_id', $user->id);
            })->latest()->first();
            
            $unreadCount = Message::where('sender_id', $otherUser->id)
                                 ->where('receiver_id', $user->id)
                                 ->whereNull('read_at')
                                 ->count();
            
            $conversationsWithLastMessage[] = [
                'user' => $otherUser,
                'last_message' => $lastMessage,
                'unread_count' => $unreadCount
            ];
        }
        
        // Trier par date du dernier message
        usort($conversationsWithLastMessage, function($a, $b) {
            if (!$a['last_message']) return 1;
            if (!$b['last_message']) return -1;
            return $b['last_message']->created_at->compare($a['last_message']->created_at);
        });
        
        return view('messages.index', compact('conversationsWithLastMessage'));
    }

    public function show($userId)
    {
        $otherUser = User::findOrFail($userId);
        $currentUser = Auth::user();
        
        // Récupérer tous les messages entre les deux utilisateurs
        $messages = Message::where(function($query) use ($currentUser, $otherUser) {
            $query->where('sender_id', $currentUser->id)
                  ->where('receiver_id', $otherUser->id);
        })->orWhere(function($query) use ($currentUser, $otherUser) {
            $query->where('sender_id', $otherUser->id)
                  ->where('receiver_id', $currentUser->id);
        })->with(['sender', 'annonce'])->orderBy('created_at', 'asc')->get();
        
        // Marquer les messages comme lus
        Message::where('sender_id', $otherUser->id)
               ->where('receiver_id', $currentUser->id)
               ->whereNull('read_at')
               ->update(['read_at' => now()]);
        
        return view('messages.show', compact('messages', 'otherUser'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000',
            'annonce_id' => 'nullable|exists:objets,id'
        ]);
        
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
            'annonce_id' => $request->annonce_id
        ]);
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message->load('sender')
            ]);
        }
        
        return redirect()->back()->with('success', 'Message envoyé avec succès !');
    }

    public function contactFromAnnonce($annonceId)
    {
        $annonce = Objet::with('user')->findOrFail($annonceId);
        $currentUser = Auth::user();
        
        // Vérifier que l'utilisateur ne contacte pas sa propre annonce
        if ($annonce->user_id === $currentUser->id) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas contacter votre propre annonce.');
        }
        
        return view('messages.contact', compact('annonce'));
    }

    public function getUnreadCount()
    {
        $count = Auth::user()->unreadMessagesCount();
        return response()->json(['count' => $count]);
    }
}
