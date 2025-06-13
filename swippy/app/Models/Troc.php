<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Troc extends Model
{
    protected $fillable = [
        'objet_offert_id',
        'objet_demande_id',
        'user_propose_id',
        'user_cible_id',
        'status',
    ];

    public function objetOffert()
    {
        return $this->belongsTo(Objet::class, 'objet_offert_id');
    }

    public function objetDemande()
    {
        return $this->belongsTo(Objet::class, 'objet_demande_id');
    }

    public function userPropose()
    {
        return $this->belongsTo(User::class, 'user_propose_id');
    }

    public function userCible()
    {
        return $this->belongsTo(User::class, 'user_cible_id');
    }
}
