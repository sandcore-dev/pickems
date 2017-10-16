<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table)
		{
		    $table->increments('id');
		    $table->string('name')->unique();
		    $table->integer('country_id')->unsigned();
		    $table->boolean('active');
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
        Schema::dropIfExists('teams');
    }
}
