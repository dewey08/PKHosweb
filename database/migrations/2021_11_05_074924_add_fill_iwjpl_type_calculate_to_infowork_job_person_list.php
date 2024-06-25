<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillIwjplTypeCalculateToInfoworkJobPersonList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('infowork_job_person_list', function (Blueprint $table) {
            if(!schema::hasColumn('IWJPL_TYPE_CALCULATE','infowork_job_person_list')){
                $table->string('IWJPL_TYPE_CALCULATE');
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
        Schema::table('infowork_job_person_list', function (Blueprint $table) {
            //
        });
    }
}
