<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoworkJobPersonStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!schema::hasTable('infowork_job_person_status')){
            Schema::create('infowork_job_person_status', function (Blueprint $table) {
                $table->id('IWJOB_PERSON_STATUS_ID');
                $table->string('IWJPS_NAME');
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
        Schema::dropIfExists('infowork_job_person_status');
    }
}
