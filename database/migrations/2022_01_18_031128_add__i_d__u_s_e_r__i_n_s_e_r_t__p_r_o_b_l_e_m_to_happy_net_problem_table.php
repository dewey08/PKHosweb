<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIDUSERINSERTPROBLEMToHappyNetProblemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('happy_net_problem', function (Blueprint $table) {
            if(!schema::hasColumn('happy_net_problem','ID_USER_INSERT_PROBLEM')){
                $table->integer('ID_USER_INSERT_PROBLEM');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('happy_net_problem', function (Blueprint $table) {
            //
        });
    }
}
