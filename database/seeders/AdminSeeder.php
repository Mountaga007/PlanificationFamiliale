<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'nom' => 'Mountaga Ba',
            'email' => 'mountaga889@gmail.com',
            'password' => 'mountaga123',
            'telephone' => '771663714',
            'role' => 'admin',
         ]);
    }
}
