<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskNotifyReport5Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable('risk_notify_report5'))
        {

        Schema::create('risk_notify_report5', function (Blueprint $table) {
                    $table->id("RISK_NOTIFY_RE5_ID",11); 
                    $table->String("RISK_NOTIFY_RE5_YEAR",255)->nullable(); 
                    $table->String("RISK_NOTIFY_RE5_ROUND",255)->nullable(); 
                    $table->date("RISK_NOTIFY_RE5_BEGINDATE",255)->nullable(); 
                    $table->date("RISK_NOTIFY_RE5_ENDDATE",255)->nullable(); 
                    $table->String("RISK_NOTIFY_RE5_DEP",255)->nullable(); 
                    $table->String("RISK_NOTIFY_RE5_PERSON",255)->nullable(); 
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
        Schema::dropIfExists('risk_notify_report5');
    }
}
