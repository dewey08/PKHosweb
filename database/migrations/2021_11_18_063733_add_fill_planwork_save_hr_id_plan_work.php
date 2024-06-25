<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillPlanworkSaveHrIdPlanWork extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plan_work', function (Blueprint $table) {
            
            if(!schema::hasColumn('plan_work','PLANWORK_SAVE_HR_ID')){
                $table->string('PLANWORK_SAVE_HR_ID')->nullable();
            } 

            if(!schema::hasColumn('plan_work','PLANWORK_STATUS')){
                $table->string('PLANWORK_STATUS')->nullable();
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
        Schema::table('plan_work', function (Blueprint $table) {
            //
        });
    }
}
