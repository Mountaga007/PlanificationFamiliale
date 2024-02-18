<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // public function definition(): array
    // {
    //     return [
    //         'nom' => 'Mountaga Ba',
    //         'email' => 'mountaga889@gmail.com',
    //         'password' => static::$password ??= Hash::make('mountaga123'),            
    //         'telephone' => '771663714',
    //         'role' => 'admin',
    //         'remember_token' => Str::random(10),
    //     ];
    // }

   public function definition(): array
   {
       return [
           'nom' => $this->faker->name,
           'email' => $this->faker->unique()->safeEmail,
           'password' => Hash::make('password123'), 
           'telephone' => $this->faker->phoneNumber,
           'role' => $this->faker->randomElement(['admin','utilisateur','personnelsante']),
           'remember_token' => Str::random(10),
       ];
   }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
