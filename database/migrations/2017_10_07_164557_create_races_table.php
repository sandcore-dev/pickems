<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('races', function (Blueprint $table)
		{
		    $table->increments('id');
		    $table->integer('season_id')->unsigned();
		    $table->integer('circuit_id')->unsigned();
		    $table->string('name');
		    $table->datetime('weekend_start');
		    $table->date('race_day');
		    $table->timestamps();
		    
		    $table->foreign('season_id')->references('id')->on('seasons');
		    $table->foreign('circuit_id')->references('id')->on('circuits');
		    
		    $table->unique( [ 'season_id', 'circuit_id', 'race_day' ] );
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
        Schema::dropIfExists('races');
    }
}
