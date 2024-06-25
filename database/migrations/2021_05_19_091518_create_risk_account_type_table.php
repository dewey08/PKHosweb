<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskAccountTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('risk_account_type'))
        {
        Schema::create('risk_account_type', function (Blueprint $table) {
            $table->id("RISK_ACCOUNTTYPE_ID",11);
            $table->String("RISK_ACCOUNTTYPE_CODE",255)->nullable(); 
            $table->String("RISK_ACCOUNTTYPE_NAME",255)->nullable();  
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
        Schema::dropIfExists('risk_account_type');
    }
}
