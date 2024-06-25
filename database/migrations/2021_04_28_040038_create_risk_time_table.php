<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('risk_rep_time'))
        {
        Schema::create('risk_rep_time', function (Blueprint $table) {
            $table->id("RISK_TIME_ID",11);
            $table->String("RISK_TIME_NAME",255)->nullable();
            $table->time("RISK_TIME_START")->nullable();
            $table->time("RISK_TIME_END")->nullable();
            $table->String("RISK_TIME_COMMENT",255)->nullable();
            $table->String("RISK_TIME_EXPORT",255)->nullable();
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
        Schema::dropIfExists('risk_time');
    }
}
