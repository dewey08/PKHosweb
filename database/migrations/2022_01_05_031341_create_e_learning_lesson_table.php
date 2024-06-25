<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateELearningLessonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_learning_lesson', function (Blueprint $table) {
            $table->increments("ID_LESSON",11);
            $table->String("NAME_LESSON",255)->nullable();
            $table->String("OBJECTIVE_LESSON",500)->nullable();
            $table->String("DETAIL_LESSON",500)->nullable();
            $table->String("TIME_LESSON",10)->nullable();
            $table->String("TEACH_LESSON",10)->nullable();
            $table->String("LINK_VIDEO_LESSON",10)->nullable();
            $table->enum("ACTIVE_LESSON",['True', 'False']);
            $table->binary('TEACH_IMG_LESSON');
            $table->binary('DOCUMENT_LESSON');
            $table->binary('VIDEO_LESSON')->nullable();
            $table->binary('IMG_LESSON')->nullable();
            $table->integer("ID_LESSON_GROUP");
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
        Schema::dropIfExists('e_learning_lesson');
    }
}
