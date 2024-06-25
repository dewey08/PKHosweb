<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateELearningScoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('e_learning_score'))
        { 
        Schema::create('e_learning_score', function (Blueprint $table) {
            $table->increments("ID_SCORE",11);
            $table->integer("ID_CHOICE_ANS");
            $table->enum('SCORE',['True', 'False']);
            $table->enum('STATUS_EXAM',['0', '1']);
            $table->integer("ID_EXAM_GROUP");
            $table->integer("ID_EXAM");
            $table->integer("ID_USER");
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
        Schema::dropIfExists('e_learning_score');
    }
}
