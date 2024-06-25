<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoworkJobDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!schema::hasTable('infowork_job_descriptions')){
            Schema::create('infowork_job_descriptions', function (Blueprint $table) {
                $table->id('IWJOB_D_ID');
                $table->string('IWJD_NAME');
                $table->boolean('IWJD_ACTIVE')->default(1);
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
        Schema::dropIfExists('infowork_job_descriptions');
    }
}
