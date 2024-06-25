<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHappyNetQuestion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('happy_net_question', function (Blueprint $table) {
            $table->increments("HAPPY_NET_QUESTION_ID",11);
            $table->String("HAPPY_NET_QUESTION",255)->nullable();
            $table->binary('HAPPY_NET_QUESTION_IMAGE');  
            $table->string("HAPPY_NET_QUESTION_COIN",40)->nullable();
            $table->enum('HAPPY_NET_QUESTION_STATUS', ['True', 'False']); 
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('happy_net_question');
    }
}
