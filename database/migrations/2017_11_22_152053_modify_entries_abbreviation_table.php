<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyEntriesAbbreviationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entries', function (Blueprint $table) {
        	$table->string('abbreviation', 3)->nullable()->after('car_number');
        	
        	$table->unique( [ 'season_id', 'team_id', 'abbreviation' ] );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entries', function (Blueprint $table) {
        	$table->dropColumn('abbreviation');
        	
        	$table->dropUnique( [ 'season_id', 'team_id', 'abbreviation' ] );
        });
    }
}
