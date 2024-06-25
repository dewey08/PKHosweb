<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskAccountDetailLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('risk_account_detail_level'))
        {

                Schema::create('risk_account_detail_level', function (Blueprint $table) {
                    $table->id("RISK_ACCDE_LE_ID",11); 
                    $table->String("RISK_ACC_ID",255)->nullable(); 
                    $table->String("RISK_ACCDE_LE_YEAR",255)->nullable(); 
                    $table->String("RISK_ACCDE_LE_RATE",255)->nullable(); 
                    $table->String("RISK_ACCDE_LE_CHANCE",255)->nullable(); 
                    $table->String("RISK_ACCDE_LE_EFFECT",255)->nullable(); 
                    $table->String("RISK_ACCDE_LE_SCORE",255)->nullable(); 
                    $table->String("RISK_ACCDE_LE_ACCEPTABLE",255)->nullable(); 
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
        Schema::dropIfExists('risk_account_detail_level');
    }
}
