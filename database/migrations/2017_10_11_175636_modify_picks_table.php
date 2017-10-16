<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyPicksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'picks', function (Blueprint $table)
		{
			$table->dropForeign( [ 'race_id' ] );
			$table->dropForeign( [ 'user_id' ] );

			$table->dropUnique( [ 'race_id', 'user_id', 'entry_id' ] );
			$table->dropUnique( [ 'race_id', 'user_id', 'rank' ] );

			$table->dropColumn( 'user_id' );
			
			$table->foreign('race_id')->references('id')->on('races');
			
			$table->integer('league_user_id')->unsigned()->after('entry_id');
			
			$table->foreign('league_user_id')->references('id')->on('league_user');

			$table->unique( [ 'race_id', 'league_user_id', 'entry_id' ] );
			$table->unique( [ 'race_id', 'league_user_id', 'rank' ] );
		}
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'picks', function (Blueprint $table)
		{
			$table->dropUnique( [ 'race_id', 'league_user_id', 'rank' ] );
			$table->dropUnique( [ 'race_id', 'league_user_id', 'entry_id' ] );
			
			$table->dropForeign( [ 'league_user_id' ] );
			
			$table->dropColumn('league_user_id');
			
			$table->unique( [ 'race_id', 'user_id', 'rank' ] );
			$table->unique( [ 'race_id', 'user_id', 'entry_id' ] );
			
			$table->foreign('user_id')->references('id')->on('users');
		}
        );
    }
}
