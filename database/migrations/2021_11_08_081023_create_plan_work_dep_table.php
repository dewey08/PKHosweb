<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanWorkDepTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('plan_work_dep')) {
        Schema::create('plan_work_dep', function (Blueprint $table) {
            $table->increments("PLANWORK_DEP_ID",11);
            $table->String("PLANWORK_ID",255)->nullable();
            $table->String("PLANWORK_HR_DEP_ID",255)->nullable();
            $table->String("PLANWORK_DEP_CODE",255)->nullable();
            $table->String("PLANWORK_DEP_NAME",255)->nullable();
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
        Schema::dropIfExists('plan_work_dep');
    }
}
