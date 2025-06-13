<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function objets()
    {
        return $this->hasMany(Objet::class);
    }

    public function trocsProposes()
    {
        return $this->hasMany(Troc::class, 'user_propose_id');
    }

    public function trocsRecus()
    {
        return $this->hasMany(Troc::class, 'user_cible_id');
    }

    public function favorites()
    {
        return $this->belongsToMany(\App\Models\Objet::class, 'favorites', 'user_id', 'objet_id')->withTimestamps();
    }

    // Relations pour les messages
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    // Méthode pour obtenir les conversations
    public function conversations()
    {
        $sentConversations = $this->sentMessages()
            ->select('receiver_id')
            ->distinct()
            ->pluck('receiver_id');

        $receivedConversations = $this->receivedMessages()
            ->select('sender_id')
            ->distinct()
            ->pluck('sender_id');

        $allUserIds = $sentConversations->merge($receivedConversations)->unique();

        return User::whereIn('id', $allUserIds)->get();
    }

    // Méthode pour obtenir les messages non lus
    public function unreadMessagesCount()
    {
        return $this->receivedMessages()->whereNull('read_at')->count();
    }
}
