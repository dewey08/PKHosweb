<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('risk_rep_location'))
        {
        Schema::create('risk_rep_location', function (Blueprint $table) {
            // $table->foreignId("RISK_LOCATION_ID",11)->unsigned(false);
            // $table->String("RISK_LOCATION_ID",11)->primary();
            $table->id("RISK_LOCATION_ID",11);
            $table->String("RISK_LOCATION_CODE",255)->nullable();
            $table->String("RISK_LOCATION_NAME",255)->nullable();
            $table->String("RISK_LOCATION_COMMENT",255)->nullable();
            $table->dateTime("updated_at")->nullable();
            $table->dateTime("created_at")->nullable();
            // $table->timestamps();
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
        Schema::dropIfExists('risk_rep_location');
    }
}
