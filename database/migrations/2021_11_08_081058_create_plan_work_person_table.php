<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanWorkPersonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('plan_work_person')) {
        Schema::create('plan_work_person', function (Blueprint $table) {
            $table->increments("PLANWORK_PERSON_ID",11);
            $table->String("PLANWORK_ID",255)->nullable();
            $table->String("PLANWORK_HR_PERSON_ID",255)->nullable();
            $table->String("PLANWORK_PERSON_NAME",255)->nullable();
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
        Schema::dropIfExists('plan_work_person');
    }
}
