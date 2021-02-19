<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;


class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->create([
                'email' => 'webmaster@localhost',
                'username' => 'webmaster',
                'active' => true,
                'is_admin' => true,
            ]);

        User::factory()
            ->count(20)
            ->create([
                'is_admin' => false,
            ]);
    }
}
