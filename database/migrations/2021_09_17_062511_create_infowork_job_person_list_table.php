<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoworkJobPersonListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!schema::hasTable('infowork_job_person_list')){
            Schema::create('infowork_job_person_list', function (Blueprint $table) {
                $table->id('IWJOB_PERSON_LIST_ID');
                $table->bigInteger('IWJOB_PERSON_ID');
                $table->bigInteger('IWKPI_ID');
                $table->float('IWJPL_NUMBER_1',5,2);
                $table->float('IWJPL_NUMBER_2',5,2);
                $table->float('IWJPL_NUMBER_3',5,2);
                $table->float('IWJPL_NUMBER_4',5,2);
                $table->float('IWJPL_NUMBER_5',5,2);
                $table->float('IWJPL_SCORE_A',5,2);
                $table->float('IWJPL_WEIGHT_B',5,2);
                $table->float('IWJPL_MULTIPLY_AB',9,2);
                $table->float('IWJPL_TARGET',5,2);
                $table->float('IWJPL_PERFORMANCE_10',5,2)->nullable();
                $table->float('IWJPL_PERFORMANCE_11',5,2)->nullable();
                $table->float('IWJPL_PERFORMANCE_12',5,2)->nullable();
                $table->float('IWJPL_PERFORMANCE_1',5,2)->nullable();
                $table->float('IWJPL_PERFORMANCE_2',5,2)->nullable();
                $table->float('IWJPL_PERFORMANCE_3',5,2)->nullable();
                $table->float('IWJPL_PERFORMANCE_4',5,2)->nullable();
                $table->float('IWJPL_PERFORMANCE_5',5,2)->nullable();
                $table->float('IWJPL_PERFORMANCE_6',5,2)->nullable();
                $table->float('IWJPL_PERFORMANCE_7',5,2)->nullable();
                $table->float('IWJPL_PERFORMANCE_8',5,2)->nullable();
                $table->float('IWJPL_PERFORMANCE_9',5,2)->nullable();
                $table->float('IWJPL_PERFORMANCE_AVG',5,2)->nullable();
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
        Schema::dropIfExists('infowork_job_person_list');
    }
}
