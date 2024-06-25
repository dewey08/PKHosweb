<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanProjectSubKpiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('plan_project_sub_kpi')){
            Schema::create('plan_project_sub_kpi', function (Blueprint $table) {
                $table->id("PRO_SUBKPI_ID",11);
                $table->String("PRO_SUB_ID",20)->nullable(); 
                $table->String("PRO_SUBKPI_NAME",600)->nullable(); 
                $table->dateTime('updated_at')->nullable();
                $table->dateTime('created_at')->nullable();
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
        Schema::dropIfExists('plan_project_sub_kpi');
    }
}
