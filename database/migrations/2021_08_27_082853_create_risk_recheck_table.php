<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskRecheckTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
  
        if (!Schema::hasTable('risk_recheck'))
        {
            Schema::create('risk_recheck', function (Blueprint $table) {
                $table->increments("RISK_RECHECK_ID",11);
                $table->date("RISK_RECHECK_DATE_SAVE");
                $table->date("RISK_RECHECK_DATE");
                $table->String("RISK_RECHECK_RISKID",100);
                $table->String("RISK_RECHECK_HEAD",255);
                $table->String("RISK_RECHECK_DETAIL",500);
                $table->String("RISK_RECHECK_TOTAL",500);
                $table->String("RISK_RECHECK_PERSON",255);
                $table->String("RISK_RECHECK_FILE",50);
                $table->String("RISK_RECHECKE_NAME",50);
                $table->String("RISK_RECHECK_FILE_2",50);
                $table->String("RISK_RECHECK_NAME_2",50);
                $table->String("RISK_RECHECK_NAME_OLD",50);
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
        Schema::dropIfExists('risk_recheck');
    }
}
