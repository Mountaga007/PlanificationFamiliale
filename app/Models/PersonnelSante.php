<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonnelSante extends Model
{
    use HasFactory;

    protected $fillable = [
        'specialite',
        'nom_structure',
        'user_id'
    ];

    public function admin()
    {
        return $this->belongsTo(User::class);
    }
}
