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

    public function admin()
    {
        return $this->belongsTo(User::class);
    }

    public function dossiersMedicaux()
    {
        return $this->hasMany(Dossier_Medical::class);
    }
}
