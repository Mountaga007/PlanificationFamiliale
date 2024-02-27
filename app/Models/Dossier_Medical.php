<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dossier_Medical extends Model
{
    use HasFactory;

    protected $fillable = [
        'prenom',
        'nom',
        'telephone',
        'adresse',
        'email',
        'statut',
        'numero_Identification',
        'age',
        'poste_avortement',
        'poste_partum',
        'methode_en_cours',
        'methode',
        'methode_choisie',
        'preciser_autres_methodes',
        'raison_de_la_visite',
        'indication',
        'effets_indesirables_complications',
        'date_visite',
        'date_prochain_rv',
    ];

    public function personnelSante()
    {
        return $this->belongsTo(PersonnelSante::class, 'personnelsante_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
