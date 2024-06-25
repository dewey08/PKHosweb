<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanWorkTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('plan_work_team')) {
        Schema::create('plan_work_team', function (Blueprint $table) {
            $table->increments("PLANWORK_TEAM_ID",11);
            $table->String("PLANWORK_ID",255)->nullable();
            $table->String("PLANWORK_HR_TEAM_ID",255)->nullable();
            $table->String("PLANWORK_TEAM_CODE",255)->nullable();
            $table->String("PLANWORK_TEAM_NAME",255)->nullable();
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
        Schema::dropIfExists('plan_work_team');
    }
}
