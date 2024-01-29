<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ressource_Planification_familiale extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'texte',
        'image',
        'admin_id',
    ];
    public function admin()
        {
            return $this->belongsTo(User::class);
        }
}
