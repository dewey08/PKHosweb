<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillJobdesPositionToInfoworkJobDescriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('infowork_job_descriptions', function (Blueprint $table) {
            if(!schema::hasColumn('infowork_job_descriptions','IWJD_POSITION')){
                $table->string('IWJD_POSITION')->nullable();
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
        Schema::table('infowork_job_descriptions', function (Blueprint $table) {
            //
        });
    }
}
