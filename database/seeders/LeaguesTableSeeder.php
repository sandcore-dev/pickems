<?php

namespace Database\Seeders;

use App\Models\League;
use App\Models\Series;
use App\Models\User;
use Illuminate\Database\Seeder;

class LeaguesTableSeeder extends Seeder
{
    public function run(): void
    {
        if (!Series::exists() && !User::exists()) {
            League::factory()
                ->has(
                    User::factory()
                        ->count(15)
                )
                ->count(5)
                ->create();
            return;
        }

        $series = Series::all();
        $users = User::all();

        League::factory()
            ->count(5)
            ->create([
                'series_id' => function () use ($series) {
                    return $series->random();
                },
            ])
            ->each(function (League $league) use ($users) {
                $league->users()
                    ->syncWithoutDetaching(
                        $users->random(rand(5, $users->count()))
                    );
            });
    }
}
