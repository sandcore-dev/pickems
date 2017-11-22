<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStandingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('standings', function (Blueprint $table)
		{
		    $table->increments('id');
		    $table->integer('user_id')->unsigned();
		    $table->integer('league_id')->unsigned();
		    $table->integer('race_id')->unsigned();
		    $table->smallInteger('rank')->unsigned()->default(0);
		    $table->integer('previous_id')->unsigned()->nullable();
		    $table->smallInteger('picked')->unsigned()->default(0);
		    $table->smallInteger('positions_correct')->unsigned()->default(0);
		    $table->timestamps();
		    
		    $table->foreign('user_id')->references('id')->on('users');
		    $table->foreign('league_id')->references('id')->on('leagues');
		    $table->foreign('race_id')->references('id')->on('races');
		    $table->foreign('previous_id')->references('id')->on('standings')->onDelete('set null');
		    
		    $table->unique( [ 'user_id', 'league_id', 'race_id' ] );
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
        Schema::dropIfExists('standings');
    }
}
