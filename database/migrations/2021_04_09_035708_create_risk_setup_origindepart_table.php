<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskSetupOrigindepartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('risk_setup_origindepart'))
        {
        Schema::create('risk_setup_origindepart', function (Blueprint $table) {
            $table->id("ORIGIN_DEPART_ID",11);
            $table->String("ORIGIN_DEPART_CODE",255);
            $table->String("ORIGIN_DEPART_NAME",255)->nullable();
            $table->String("LEVEL_ROOM_ID",100)->nullable();
            $table->dateTime("updated_at")->nullable();
            $table->dateTime("created_at")->nullable();
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
        Schema::dropIfExists('risk_setup_origindepart');
    }
}
