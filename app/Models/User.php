<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'email',
        'password',
        'telephone',
        'image',
        'role',
        'statut_compte',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    //ligne ajouter
     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

     public function personnelSante()
     {
         return $this->hasOne(PersonnelSante::class);
     }

     public function dossierMedical()
    {
        return $this->hasOne(Dossier_Medical::class);
    }

    //ligne ajouter
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function Ressource_PF()
    {
        return $this->hasMany(Ressource_Planification_familiale::class);
    }

    public function Information_PF()
    {
        return $this->hasMany(Information_Planification_Familiale::class);

    }


    public function forum()
    {
        return $this->hasMany(Forum_Communication::class);
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }

}
