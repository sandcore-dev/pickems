<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCircuitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('circuits', function (Blueprint $table)
		{
		    $table->increments('id');
		    $table->string('name')->unique();
		    $table->smallInteger('length')->unsigned()->nullable();
		    $table->string('city')->nullable();
		    $table->string('area')->nullable();
		    $table->integer('country_id')->unsigned();
		    $table->timestamps();
		    
		    $table->foreign('country_id')->references('id')->on('countries');
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
        Schema::dropIfExists('circuits');
    }
}
