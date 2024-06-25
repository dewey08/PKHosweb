<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskRepProgramTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('risk_rep_program'))
        {
        Schema::create('risk_rep_program', function (Blueprint $table) {
            $table->id("RISK_REPPROGRAM_ID",11);          
            $table->String("RISK_REPPROGRAM_NAME",255)->nullable();
            $table->String("RISK_REPPROGRAM_DETAIL",500)->nullable();
            $table->String("RISK_REPPROGRAM_CLINICTYPE_ID",11)->nullable();
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
        Schema::dropIfExists('risk_rep_program');
    }
}
