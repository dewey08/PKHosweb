<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateELearningExamChoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!schema::hasTable('e_learning_exam_choice')){
        Schema::create('e_learning_exam_choice', function (Blueprint $table) {
            $table->increments("ID_EXAM_CHOICE",11);
            $table->String("EXAM_CHOICE",500)->nullable();
            $table->enum('ANSWER_EXAM_CHOICE',['True', 'False']);
            $table->enum('ACTIVE_EXAM_CHOICE',['True', 'False']);
            $table->integer("ID_EXAM");
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
        Schema::dropIfExists('e_learning_exam_choice');
    }
}
