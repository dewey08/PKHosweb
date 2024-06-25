<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalSetupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('medical_setup'))
{

        Schema::create('medical_setup', function (Blueprint $table) {
            $table->increments("SETUP_ID",11);
            $table->String("SETUP_BUY_ID",255);
            $table->String("SETUP_CONDISION_ID",50);
            $table->String("SETUP_CONDISION_RESION",255);
            $table->integer("SETUP_SUP_TYPE_ID")->length(50);
            $table->String("SETUP_CON_DETAIL",255);
            $table->integer("SETUP_ASPECT_ID")->length(50);
            $table->date("SETUP_DATE_WANT_USE",50);
            $table->String("SETUP_DATE_WANT_COUNT",255);
            $table->String("SETUP_RESON_NAME",255);
            
            $table->integer("SETUP_MONEY_GROUP_ID")->length(50);
            $table->integer("SETUP_BUDGET_ID")->length(50);
            $table->integer("SETUP_PURCHASE_LEADER_ID")->length(50);
            $table->integer("SETUP_PURCHASE_OFFICER_ID")->length(50);
            $table->integer("SETUP_PURCHASE_HEAD_ID")->length(50);
            $table->String("SETUP_THEBOARD",255);
            $table->integer("SETUP_METHOD_ID")->length(50);

            $table->dateTime("updated_at");
            $table->dateTime("created_at");
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
        Schema::dropIfExists('medical_setup');
    }
}
