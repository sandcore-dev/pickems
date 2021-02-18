<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Entry;

class EntriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Entry::factory()
            ->times(50)
            ->create();
    }
}
