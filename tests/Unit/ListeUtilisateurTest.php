<?php

namespace Tests\Unit;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CalculPeriodeOvulationController;
use Tests\TestCase;
use App\Models\User;
//use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithFaker;
use Egulias\EmailValidator\Validation\EmailValidation;
use Database\Factories\UserFactory;

class ListeUtilisateurTest extends TestCase
{

    /**
     * Teste l'accès à la liste des utilisateurs après la connexion.
     */

     //Vérifier si l'admin à l'accès à la liste des utilisateurs
    public function testListeUtilisateur(): void
    {
        // Effectue la connexion
        $loginData = [
            'email' => 'mountaga889@gmail.com',
            'password' => 'mountaga123',
        ];
        $loginResponse = $this->post('api/auth/login', $loginData);

        // Vérifie l'accès à la liste des utilisateurs après la connexion
        $loginResponse = $this->get('api/liste_utilisateur');
        $loginResponse->assertStatus(200);
    }

    //Les autres types de tests peuvent être ajoutés :

    public function testListeMessageAdmin(): void
    {
        // Effectue la connexion
        $loginData = [
            'email' => 'mountaga889@gmail.com',
            'password' => 'mountaga123',
        ];
        $loginResponse = $this->post('api/auth/login', $loginData);

        // Vérifie l'accès à la liste des utilisateurs après la connexion
        $loginResponse = $this->get('api/liste_message');
        $loginResponse->assertStatus(200);
    }

    public function testListeGeneraleDossierMedicalAdmin(): void
    {
        // Effectue la connexion
        $loginData = [
            'email' => 'mountaga889@gmail.com',
            'password' => 'mountaga123',
        ];
        $loginResponse = $this->post('api/auth/login', $loginData);

        // Vérifie l'accès à la liste des utilisateurs après la connexion
        $loginResponse = $this->get('api/listes_generale_DM');
        $loginResponse->assertStatus(200);
    }

    public function testListeForumCommunication(): void
     {
        $response = $this->post('/api/auth/login', [
            'email' => 'mountaga07@hotmail.com',
            'password' => 'mountaga007@',
        ]);
         // Vérifie l'accès à la liste des utilisateurs spéciaux
         $response = $this->get('api/liste_forum');
         $response->assertStatus(200);
     }

}
