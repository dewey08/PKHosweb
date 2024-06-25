<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHAPPYNETQUESTIONIDGROUPToHappyNetQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('happy_net_question', function (Blueprint $table) {
            if(!schema::hasColumn('happy_net_question','HAPPY_NET_QUESTION_ID_GROUP')){
                $table->integer('HAPPY_NET_QUESTION_ID_GROUP');
              
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
        Schema::table('happy_net_question', function (Blueprint $table) {
            //
        });
    }
}
