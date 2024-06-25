<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillExpectedResultRangeToInfoworkJobPerson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('infowork_job_person', function (Blueprint $table) {
            if(!schema::hasColumn('IWJJOB_WORK_ACHIEVEMENT_10_TO_3','infowork_job_person')){
                $table->float('IWJJOB_WORK_ACHIEVEMENT_10_TO_3',5,2)->nullable();
            }
            if(!schema::hasColumn('IWJJOB_WORK_ACHIEVEMENT_4_TO_9','infowork_job_person')){
                $table->float('IWJJOB_WORK_ACHIEVEMENT_4_TO_9',5,2)->nullable();
            }
            if(!schema::hasColumn('IWJJOB_WORK_ACHIEVEMENT','infowork_job_person')){
                $table->float('IWJJOB_WORK_ACHIEVEMENT',5,2)->nullable();
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
        Schema::table('infowork_job_person', function (Blueprint $table) {
            //
        });
    }
}
