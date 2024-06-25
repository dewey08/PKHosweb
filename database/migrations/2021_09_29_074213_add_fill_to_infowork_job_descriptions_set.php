<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillToInfoworkJobDescriptionsSet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('infowork_job_descriptions_set', function (Blueprint $table) {
            if(!schema::hasColumn('infowork_job_descriptions_set','created_at') && !schema::hasColumn('infowork_job_descriptions_set','updated_at')){
                $table->timestamps();
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
        Schema::table('infowork_job_descriptions_set', function (Blueprint $table) {
            //
        });
    }
}
