<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillInRiskAccountDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_account_detail', function (Blueprint $table) {
            
         
                if (!Schema::hasColumn('risk_account_detail', 'RISK_TYPE_ID'))
                {
                    $table->string("RISK_TYPE_ID",255)->nullable();
                }  

                if (!Schema::hasColumn('risk_account_detail', 'RISK_ACC_FACTOR'))
                {
                    $table->string("RISK_ACC_FACTOR",255)->nullable();
                }  
        


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('risk_account_detail', function (Blueprint $table) {
            //
        });
    }
}
