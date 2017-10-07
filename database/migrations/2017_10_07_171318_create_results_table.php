<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table)
		{
		    $table->increments('id');
		    $table->integer('rank')->unsigned();
		    $table->integer('race_id')->unsigned();
		    $table->integer('entry_id')->unsigned();
		    $table->timestamps();
		    
		    $table->foreign('race_id')->references('id')->on('races');
		    $table->foreign('entry_id')->references('id')->on('entries');
		    
		    $table->unique( [ 'rank', 'race_id', 'entry_id' ] );
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
        Schema::dropIfExists('results');
    }
}
