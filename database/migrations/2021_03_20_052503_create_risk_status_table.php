<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateRiskStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('risk_status'))
        {
        
        Schema::create('risk_status', function (Blueprint $table) {
            $table->increments("RISK_STATUS_ID",11);
            $table->String("RISK_STATUS_NAME",255);
            $table->String("RISK_STATUS_NAME_TH",255);
            $table->dateTime("updated_at")->nullable();
            $table->dateTime("created_at")->nullable();
        });
        DB::unprepared(file_get_contents('database/db/risk_status.sql'));
    }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('risk_status');
    }
}
