<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateELearningExamGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!schema::hasTable('e_learning_exam_group')){
        Schema::create('e_learning_exam_group', function (Blueprint $table) {
            $table->increments("ID_EXAM_GROUP",11);
            $table->String("NAME_EXAM_GROUP",500)->nullable();
            $table->String("SCORE_CRITERIA",20)->nullable();
            $table->integer("ID_LESSON");
            $table->enum("ACTIVE_EXAM_GROUP",['True', 'False']);
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
        Schema::dropIfExists('e_learning_exam_group');
    }
}
