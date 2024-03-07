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
        $response = $this->post('/api/auth/login', [
            'email' => 'mountaga07@hotmail.com',
            'password' => 'mountaga007@',
        ]);
        $this->assertAuthenticated();
        $response->assertStatus(200);
     }

    public function testUserLogout(): void
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'mountaga07@hotmail.com',
            'password' => 'mountaga007@',
        ]); 
        $response = $this->post('/api/auth/logout');
        $this->assertGuest();
        $response->assertStatus(200);
    }
     
    

}
