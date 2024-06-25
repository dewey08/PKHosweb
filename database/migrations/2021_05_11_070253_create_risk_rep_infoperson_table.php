<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskRepInfopersonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('risk_rep_infoperson'))
        {
        Schema::create('risk_rep_infoperson', function (Blueprint $table) {
            $table->id("RISK_REP_PERID",11);
            $table->String("RISK_REP_PERSON_ID",11)->nullable(); 
            $table->String("RISK_REP_PERSON_NAME",255)->nullable();  
            $table->String("RISKREP_ID",11)->nullable();         
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
        Schema::dropIfExists('risk_rep_infoperson');
    }
}
