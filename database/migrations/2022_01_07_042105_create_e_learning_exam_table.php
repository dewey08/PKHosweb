<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateELearningExamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('e_learning_exam'))
        {
                Schema::create('e_learning_exam', function (Blueprint $table) {
                    $table->increments("ID_EXAM",11);
                    $table->String("QUESTION_EXAM",500)->nullable();
                    $table->binary('QUESTION_IMG_EXAMP');
                    $table->integer("ID_EXAM_GROUP");
                    $table->enum('ACTIVE_EXAM',['True', 'False']);
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
        Schema::dropIfExists('e_learning_exam');
    }
}
