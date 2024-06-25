<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskNotifyReport4Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable('risk_notify_report4'))
        {


                Schema::create('risk_notify_report4', function (Blueprint $table) {
                            $table->id("RISK_NOTIFY_RE4_ID",11); 
                            $table->String("RISK_NOTIFY_RE4_YEAR",255)->nullable(); 
                            $table->date("RISK_NOTIFY_RE4_BEGINDATE",255)->nullable(); 
                            $table->date("RISK_NOTIFY_RE4_ENDDATE",255)->nullable(); 
                            $table->String("RISK_NOTIFY_RE4_DEP",255)->nullable(); 
                            $table->String("RISK_NOTIFY_RE4_PERSON",255)->nullable(); 
                            $table->String("RISK_NOTIFY_RE4_ENV",1000)->nullable(); 
                            $table->String("RISK_NOTIFY_RE4_RESULTENV",1000)->nullable(); 
                            $table->String("RISK_NOTIFY_RE4_RATE",1000)->nullable(); 
                            $table->String("RISK_NOTIFY_RE4_RESULTRATE",1000)->nullable();
                            $table->String("RISK_NOTIFY_RE4_ACT",1000)->nullable(); 
                            $table->String("RISK_NOTIFY_RE4_RESULTACT",1000)->nullable();
                            $table->String("RISK_NOTIFY_RE4_IT",1000)->nullable(); 
                            $table->String("RISK_NOTIFY_RE4_RESULTIT",1000)->nullable();
                            $table->String("RISK_NOTIFY_RE4_TAG",1000)->nullable(); 
                            $table->String("RISK_NOTIFY_RE4_RESULTTAG",1000)->nullable();      
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
        Schema::dropIfExists('risk_notify_report4');
    }
}
