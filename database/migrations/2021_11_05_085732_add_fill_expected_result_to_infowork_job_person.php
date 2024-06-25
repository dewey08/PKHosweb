<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillExpectedResultToInfoworkJobPerson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('infowork_job_person', function (Blueprint $table) {
            if(!schema::hasColumn('IWJOB_EXPECTED_RESULT','infowork_job_person')){
                $table->string('IWJOB_EXPECTED_RESULT');
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
