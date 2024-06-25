<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHappyNetAnswer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('happy_net_answer'))
        { 
        Schema::create('happy_net_answer', function (Blueprint $table) {
            $table->increments("HAPPY_NET_ANSWER_ID",11);
            $table->integer('HAPPY_NET_QUESTION_ID');
            $table->String("HAPPY_NET_ANSWER_SCORE",250)->nullable();
            $table->integer('ID_USER');
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
        Schema::dropIfExists('happy_net_answer');
    }
}
