<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHappyNetProblem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('happy_net_problem'))
        { 
        Schema::create('happy_net_problem', function (Blueprint $table) {
            $table->increments("HAPPY_NET_PROBLEM_ID", 11);
            $table->String("HAPPY_NET_PROBLEM", 900)->nullable();
            $table->integer('ID_USER');
            $table->integer('HAPPY_NET_DIFFICULTY_ID');
            
            $table->String("HAPPY_NET_PROBLEM_FNAME", 250)->nullable();
            $table->String("HAPPY_NET_PROBLEM_LNAME", 250)->nullable();
            $table->enum('HAPPY_NET_PROBLEM_STATUS', ['True', 'False']); 
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('created_at')->nullable();
        });
    }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('happy_net_problem');
    }
}
