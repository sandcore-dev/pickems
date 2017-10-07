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
		    $table->integer('race_id')->unsigned();
		    $table->smallInteger('rank')->unsigned();
		    $table->integer('previous_id')->unsigned()->nullable();
		    $table->smallInteger('picked')->unsigned();
		    $table->smallInteger('positions_correct')->unsigned();
		    $table->timestamps();
		    
		    $table->foreign('user_id')->references('id')->on('users');
		    $table->foreign('race_id')->references('id')->on('races');
		    $table->foreign('previous_id')->references('id')->on('standings')->onDelete('set null');
		    
		    $table->unique( [ 'user_id', 'race_id' ] );
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
