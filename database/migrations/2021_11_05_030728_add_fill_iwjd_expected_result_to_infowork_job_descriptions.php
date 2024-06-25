<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillIwjdExpectedResultToInfoworkJobDescriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('infowork_job_descriptions', function (Blueprint $table) {
            if(!schema::hasColumn('IWJD_EXPECTED_RESULT','infowork_job_descriptions')){
                $table->string('IWJD_EXPECTED_RESULT',400);
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
    }
}
