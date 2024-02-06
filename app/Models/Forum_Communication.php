<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum_Communication extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'texte',
        'image',
    ];


    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }
}
