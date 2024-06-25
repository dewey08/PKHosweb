<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillScoreAndPerformanceAvgToInfoworkJobPersonList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('infowork_job_person_list', function (Blueprint $table) {
            if(!schema::hasColumn('IWJPL_SCORE_RESULT_ALL','infowork_job_person_list')){
                $table->float('IWJPL_SCORE_RESULT_ALL',5,2)->nullable();
            }
            if(!schema::hasColumn('IWJPL_SCORE_RESULT_10_TO_3','infowork_job_person_list')){
                $table->float('IWJPL_SCORE_RESULT_10_TO_3',5,2)->nullable();
            }
            if(!schema::hasColumn('IWJPL_SCORE_RESULT_4_TO_9','infowork_job_person_list')){
                $table->float('IWJPL_SCORE_RESULT_4_TO_9',5,2)->nullable();
            }
            if(!schema::hasColumn('IWJPL_PERFORMANCE_AVG_10_TO_3','infowork_job_person_list')){
                $table->float('IWJPL_PERFORMANCE_AVG_10_TO_3',5,2)->nullable();
            }
            if(!schema::hasColumn('IWJPL_PERFORMANCE_AVG_4_TO_9','infowork_job_person_list')){
                $table->float('IWJPL_PERFORMANCE_AVG_4_TO_9',5,2)->nullable();
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
        Schema::table('infowork_job_person_list', function (Blueprint $table) {
            //
        });
    }
}
