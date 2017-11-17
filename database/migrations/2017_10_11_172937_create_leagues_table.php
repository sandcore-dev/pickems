<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaguesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leagues', function (Blueprint $table)
		{
		    $table->increments('id');
		    $table->integer('series_id')->unsigned();
		    $table->string('name')->unique();
		    $table->timestamps();

		    $table->foreign('series_id')->references('id')->on('series');
		}
        );
        
        Schema::create('league_user', function (Blueprint $table)
		{
		    $table->increments('id');
		    $table->integer('league_id')->unsigned();
		    $table->integer('user_id')->unsigned();
		    $table->timestamps();
		    
		    $table->foreign('league_id')->references('id')->on('leagues');
		    $table->foreign('user_id')->references('id')->on('users');
		    
		    $table->unique( [ 'league_id', 'user_id' ] );
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
        Schema::dropIfExists('league_user');
        
        Schema::dropIfExists('leagues');
    }
}
