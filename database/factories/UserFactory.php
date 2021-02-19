<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName,
            'email' => $this->faker->unique()->safeEmail,
            'locale'  => Str::lower($this->faker->locale),
            'reminder' => $this->faker->boolean,
            'username' => $this->faker->unique()->userName,
            'password' => '$2y$10$z0d5MAIFb40cF8Hcmg/8WeUf/95yGq6ajNkjcLIO93WmpLvMjanHO', // password
            'active' => $this->faker->boolean,
            'is_admin' => $this->faker->boolean(25),
            'remember_token' => Str::random(10),
        ];
    }
}
