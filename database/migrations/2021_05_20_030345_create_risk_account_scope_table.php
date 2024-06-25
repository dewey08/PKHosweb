<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskAccountScopeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('risk_account_scope'))
        {
        Schema::create('risk_account_scope', function (Blueprint $table) {
            $table->id("RISK_ACCOUNTSCOPE_ID",11);
            $table->String("RISK_ACCOUNTSCOPE_CODE",255)->nullable(); 
            $table->String("RISK_ACCOUNTSCOPE_NAME",255)->nullable();  
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
        Schema::dropIfExists('risk_account_scope');
    }
}
