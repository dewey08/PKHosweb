<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskRepLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('risk_rep_level'))
        {
        Schema::create('risk_rep_level', function (Blueprint $table) {
            $table->id("RISK_REP_LEVEL_ID",11);          
            $table->String("RISK_REP_LEVEL_CODE",255)->nullable();
            $table->String("RISK_REP_LEVEL_NAME",255)->nullable();
            $table->String("RISK_REP_LEVEL_DETAIL",255)->nullable();
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
        Schema::dropIfExists('risk_rep_level');
    }
}
