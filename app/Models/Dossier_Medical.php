<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dossier_Medical extends Model
{
    use HasFactory;

    protected $fillable = [
        'statut',
        'numero_Identification',
        'new_programme',
        'prenom',
        'nom',
        'age',
        'adresse',
        'telephone',
        'poste_avortement',
        'poste_partum',
        'pilule',
        'dui',
        'injection',
        'implant', 
        'anneau_vaginale_a_progresterone',
        'condom',
        'cu',
        'methode_naturelle',
        'preciser_autres_methodes',
        'raison_de_la_visite',
        'indication',
        'effets_indesirables_complications',    
        'service_additiojnale',
        'observation',
        'date_visite',
        'date_prochain_rv',
        'tout',
        'hrz',
        //'personnelsante_id',
    ];

    public function personnelSante()
    {
        return $this->belongsTo(PersonnelSante::class);
    }

    public function utilisateur()
    {
        return $this->belongsTo(User::class);
    }
}
