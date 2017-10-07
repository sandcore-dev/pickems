<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entries', function (Blueprint $table)
		{
		    $table->increments('id');
		    $table->integer('season_id')->unsigned();
		    $table->integer('team_id')->unsigned();
		    $table->integer('driver_id')->unsigned();
		    $table->tinyInteger('car_number')->unsigned();
		    $table->boolean('active');
		    $table->timestamps();
		    
		    $table->foreign('season_id')->references('id')->on('seasons');
		    $table->foreign('team_id')->references('id')->on('teams');
		    $table->foreign('driver_id')->references('id')->on('drivers');
		    
		    $table->unique( [ 'season_id', 'team_id', 'driver_id' ] );
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
        Schema::dropIfExists('entries');
    }
}
