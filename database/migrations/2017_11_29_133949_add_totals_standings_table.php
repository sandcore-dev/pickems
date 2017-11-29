<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTotalsStandingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('standings', function (Blueprint $table) {
        	$table->smallInteger('previous_rank')->unsigned()->nullable()->after('rank');
        	$table->smallInteger('total')->unsigned()->default(0)->after('previous_id');
        	$table->smallInteger('total_overall')->unsigned()->default(0)->after('previous_id');
        	$table->smallInteger('total_picked')->unsigned()->default(0)->after('total_overall');
        	$table->smallInteger('total_positions_correct')->unsigned()->default(0)->after('total_picked');
        	$table->boolean('carry_over')->default(0)->after('race_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('standings', function (Blueprint $table) {
        	$table->dropColumn('previous_rank');
        	$table->dropColumn('total');
        	$table->dropColumn('total_overall');
        	$table->dropColumn('total_picked');
        	$table->dropColumn('total_positions_correct');
        	$table->dropColumn('carry_over');
        });
    }
}
