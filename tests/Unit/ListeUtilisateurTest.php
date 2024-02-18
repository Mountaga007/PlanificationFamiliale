<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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
}

