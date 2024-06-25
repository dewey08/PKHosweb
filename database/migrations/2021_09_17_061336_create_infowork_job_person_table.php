<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoworkJobPersonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!schema::hasTable('infowork_job_person')){
            Schema::create('infowork_job_person', function (Blueprint $table) {
                $table->id('IWJOB_PERSON_ID');
                $table->bigInteger('IWJOB_D_ID');
                $table->bigInteger('PERSON_ID');
                $table->integer('IWJP_BUDGETYEAR');
                $table->bigInteger('IWJOB_PERSON_STATUS_ID');
                $table->bigInteger('IWJP_CREATED_ID');
                $table->bigInteger('IWJP_ASSESSOR_ID_1')->nullable();
                $table->bigInteger('IWJP_ASSESSOR_ID_2')->nullable();
                $table->timestamps();
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
        Schema::dropIfExists('infowork_job_person');
    }
}
