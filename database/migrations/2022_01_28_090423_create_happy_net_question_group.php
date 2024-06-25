<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHappyNetQuestionGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('happy_net_question_group'))
        {
        Schema::create('happy_net_question_group', function (Blueprint $table) {
            $table->increments("HAPPY_NET_QUESTION_GROUP_ID", 11);
            $table->String("HAPPY_NET_QUESTION_GROUP", 300)->nullable();
            $table->integer('HAPPY_NET_ID_QUESTION');
            $table->enum('HAPPY_NET_QUESTION_GROUP_STATUS', ['True', 'False']); 
            $table->date('DATE_SAVE');
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
        Schema::dropIfExists('happy_net_question_group');
    }
}
