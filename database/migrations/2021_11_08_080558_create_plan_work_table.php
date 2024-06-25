<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanWorkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('plan_work')) {
            
        Schema::create('plan_work', function (Blueprint $table) {
            $table->increments("PLANWORK_ID",11);
            $table->String("PLANWORK_CODE",255)->nullable();
            $table->String("PLANWORK_BUDGET",255)->nullable();
            $table->String("PLANWORK_STRATEGIC_ID",255)->nullable();
            $table->String("PLANWORK_TARGET_ID",255)->nullable();
            $table->String("PLANWORK_KPI_ID",255)->nullable();
            $table->String("PLANWORK_HEAD",255)->nullable();
            $table->date("PLANWORK_DATE_BEGIN",50);
            $table->date("PLANWORK_DATE_END",50);
            $table->String("PLANWORK_PRO_TYPE",255)->nullable();
            $table->String("PLANWORK_PRO_TEAM_NAME",255)->nullable();
            $table->String("PLANWORK_PRO_TEAM_HR_ID",255)->nullable();
            $table->String("PLANWORK_DETAIL",255)->nullable();
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
        Schema::dropIfExists('plan_work');
    }
}
