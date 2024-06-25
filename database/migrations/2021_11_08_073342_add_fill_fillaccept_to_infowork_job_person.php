<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillFillacceptToInfoworkJobPerson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('infowork_job_person', function (Blueprint $table) {
            if(!schema::hasColumn('infowork_job_person','IWJOB_BE_INFORMED')){
                $table->boolean('IWJOB_BE_INFORMED')->default(0);
            }
            if(!schema::hasColumn('infowork_job_person','IWJOB_BE_INFORMED_DATE')){
                $table->date('IWJOB_BE_INFORMED_DATE')->nullable();
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
