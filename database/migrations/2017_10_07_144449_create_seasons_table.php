<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seasons', function (Blueprint $table)
		{
		    $table->increments('id');
		    $table->integer('series_id')->unsigned();
		    $table->decimal('start_year', 4, 0);
		    $table->decimal('end_year', 4, 0);
		    $table->timestamps();
		    
		    $table->foreign('series_id')->references('id')->on('series');
		    $table->unique( [ 'series_id', 'start_year', 'end_year' ] );
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
        Schema::dropIfExists('seasons');
    }
}
