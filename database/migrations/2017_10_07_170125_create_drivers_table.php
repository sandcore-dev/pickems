<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table)
		{
		    $table->increments('id');
		    $table->string('first_name');
		    $table->string('last_name');
		    $table->integer('country_id')->unsigned()->nullable();
		    $table->boolean('active');
		    $table->timestamps();
		    
		    $table->foreign('country_id')->references('id')->on('countries');
		    $table->unique( [ 'first_name', 'last_name', 'country_id' ] );
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
        Schema::dropIfExists('drivers');
    }
}
