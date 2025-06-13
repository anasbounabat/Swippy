<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Objet extends Model
{
    protected $fillable = ['title', 'description', 'user_id', 'category_id', 'photo', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function trocsOfferts()
    {
        return $this->hasMany(Troc::class, 'objet_offert_id');
    }

    public function trocsDemandes()
    {
        return $this->hasMany(Troc::class, 'objet_demande_id');
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(\App\Models\User::class, 'favorites', 'objet_id', 'user_id')->withTimestamps();
    }
}
