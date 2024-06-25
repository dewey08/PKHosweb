<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskNotifyReport5SubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable('risk_notify_report5_sub'))
        {
                Schema::create('risk_notify_report5_sub', function (Blueprint $table) {

                    $table->id("RISK_NOTIFY_RE5_SUB_ID",11); 
                    $table->String("RISK_NOTIFY_RE5_ID",11); 
                    $table->String("RISK_NOTIFY_RE5_SUB_RISK",255)->nullable(); 
                    $table->String("RISK_NOTIFY_RE5_SUB_CONTROL",255)->nullable(); 
                    $table->String("RISK_NOTIFY_RE5_SUB_RATE",255)->nullable(); 
                    $table->String("RISK_NOTIFY_RE5_SUB_HAVE",255)->nullable(); 
                    $table->String("RISK_NOTIFY_RE5_SUB_IMPROVE",255)->nullable(); 
                    $table->String("RISK_NOTIFY_RE5_SUB_DEP",255)->nullable(); 
                    $table->String("RISK_NOTIFY_RE5_SUB_TIME",255)->nullable();
                    $table->String("RISK_NOTIFY_RE5_SUB_STATUS",255)->nullable();  
                    $table->String("RISK_NOTIFY_RE5_SUB_TAG",255)->nullable(); 
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
        Schema::dropIfExists('risk_notify_report5_sub');
    }
}
