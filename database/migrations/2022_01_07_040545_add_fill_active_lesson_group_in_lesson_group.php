<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillActiveLessonGroupInLessonGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('elearning_lesson_group', function (Blueprint $table) {
            if(!schema::hasColumn('elearning_lesson_group','ACTIVE_LESSON_GROUP')){
                $table->enum('ACTIVE_LESSON_GROUP',['True', 'False']);
            } 
        });
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lesson_group', function (Blueprint $table) {
            //
        });
    }
}
