<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyStandingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('standings', function (Blueprint $table) {
        	$table->dropForeign( [ 'race_id' ] );
        	$table->dropForeign( [ 'user_id' ] );
        	
        	$table->dropUnique( [ 'user_id', 'race_id' ] );
        	
        	$table->dropColumn('user_id');
        	
        	$table->integer('league_user_id')->unsigned()->after('race_id');
        	
        	$table->foreign('league_user_id')->references('id')->on('league_user');
        	$table->foreign('race_id')->references('id')->on('races');
        	
        	$table->unique( [ 'league_user_id', 'race_id' ] );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('standings', function (Blueprint $table) {
		$table->dropForeign( [ 'league_user_id' ] );

		$table->dropUnique( [ 'league_user_id', 'race_id' ] );
		
		$table->dropColumn('league_user_id');
		
		$table->integer('user_id')->unsigned();
		
		$table->foreign('user_id')->references('id')->on('users');
		$table->foreign('race_id')->references('id')->on('races');

		$table->unique( [ 'user_id', 'race_id' ] );
        });
    }
}
