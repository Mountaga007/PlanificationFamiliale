<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;


class AuthentificationUserTest extends TestCase
{
    /**
     * A basic unit test example.
     */

     //Vérifier si l'utilisateur est connecté

     public function testUserLogin(): void
     {
         $user = User::factory()->create();
         $data = [
             'email' => $user->email,
             'password' => 'password123',
         ];
         $loginuser = $this->post('api/auth/login', $data);
         $loginuser->assertStatus(200);
     }

    // public function testUserLogout(): void
    // {
    //     // Crée un utilisateur valide pour le test
    //     $user = User::factory()->create();
    
    //     // Authentifiez l'utilisateur/Simule l'authentification de l'utilisateur
    //     $this->actingAs($user); 
    
    //     // Envoie une requête de déconnexion
    //     $response = $this->postJson('api/auth/logout');
    
    //     // S'assure que le code d'état est 200
    //     $response->assertStatus(200);
    // }
     
    

}
