<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHAPPYNETPROBLEMHEAD extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('happy_net_problem', function (Blueprint $table) {
            if(!schema::hasColumn('happy_net_problem','HAPPY_NET_PROBLEM_HEAD')){
                $table->String("HAPPY_NET_PROBLEM_HEAD", 250)->nullable();
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
