<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateELearningTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elearning_lesson_group', function (Blueprint $table) {
            $table->increments("ID_LESSON_GROU",11);
            $table->String("NAME_LESSON_GROUP",255)->nullable();
            $table->binary('IMG_LESSON_GROUP');
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
        Schema::dropIfExists('elearning_lesson_group');
    }
}
