<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskRiskAccountDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('risk_account_detail'))
        {
                Schema::create('risk_account_detail', function (Blueprint $table) {
                    $table->id("RISK_ACC_ID",11);
                    $table->String("RISK_ACC_ISSUE",255)->nullable(); 
                    $table->String("RISK_ACC_MISSION",255)->nullable(); 
                    $table->String("RISK_ACC_OBJ",255)->nullable(); 
                    $table->String("RISK_ACC_RISK",255)->nullable(); 
                    $table->String("RISK_ACC_CONTROLS",255)->nullable(); 
                    $table->String("RISK_ACC_MANAGE",255)->nullable(); 
                    $table->String("RISK_ACC_AGENCY",255)->nullable(); 
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
        Schema::dropIfExists('risk_account_detail');
    }
}
