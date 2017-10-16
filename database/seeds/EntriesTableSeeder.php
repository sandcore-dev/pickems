<?php

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
    	factory( Entry::class, 50 )->create();
    }
}
