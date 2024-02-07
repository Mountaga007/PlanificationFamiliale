<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information_Planification_Familiale extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'texte',
        'image',
        'admin_id',
        'document',
    ];

    public function admin()
        {
            return $this->belongsTo(User::class);
        }
}
