<?php

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$countries = Countries::getList( 'en', 'php' );
    	
    	foreach( $countries as $code => $name )
    	{
		DB::table('countries')->insert(
			[
				'code'		=> $code,
				'name'		=> $name,
				'created_at'	=> date('Y-m-d H:i:s'),
				'updated_at'	=> date('Y-m-d H:i:s'),
			]
		);
	}
    }
}
