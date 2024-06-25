<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoworkJobDescriptionsSetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!schema::hasTable('infowork_job_descriptions_set')){
            Schema::create('infowork_job_descriptions_set', function (Blueprint $table) {
                $table->id('IWJOB_D_SET_ID');
                $table->bigInteger('IWJOB_D_ID');
                $table->bigInteger('IWKPI_ID');
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
        Schema::dropIfExists('infowork_job_descriptions_set');
    }
}
