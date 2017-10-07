<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePicksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('picks', function (Blueprint $table)
		{
		    $table->increments('id');
		    $table->integer('race_id')->unsigned();
		    $table->integer('entry_id')->unsigned();
		    $table->integer('user_id')->unsigned();
		    $table->smallInteger('rank')->unsigned();
		    $table->boolean('carry_over')->default(0);
		    $table->timestamps();
		    
		    $table->foreign('race_id')->references('id')->on('races');
		    $table->foreign('entry_id')->references('id')->on('entries');
		    $table->foreign('user_id')->references('id')->on('users');
		    
		    // Only one entry possible per race and user
		    $table->unique( [ 'race_id', 'user_id', 'entry_id' ] );
		    
		    // Only one rank possible per race and user
		    $table->unique( [ 'race_id', 'user_id', 'rank' ] );
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
        Schema::dropIfExists('picks');
    }
}
