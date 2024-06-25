<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUSERLIKEToHappyNetProblemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('happy_net_problem', function (Blueprint $table) {
            if(!schema::hasColumn('happy_net_problem','USER_LIKE','PROBLEM_USER_LIKE')){
                $table->enum('USER_LIKE', ['True', 'False']); 
                $table->enum('PROBLEM_USER_LIKE', ['True', 'False']); 
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
