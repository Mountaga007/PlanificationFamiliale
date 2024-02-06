<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonnelSante extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricule',
        'structure',
        'service'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dossiersMedicaux()
    {
        return $this->hasMany(Dossier_Medical::class, 'personnelsante_id');
    }
}
