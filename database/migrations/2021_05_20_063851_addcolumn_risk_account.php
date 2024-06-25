<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddcolumnRiskAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_account',function (Blueprint $table) {           
            if (!Schema::hasColumn('risk_account', 'RISK_ACCOUNT_SCOPE_ID'))
            {
                $table->String("RISK_ACCOUNT_SCOPE_ID",255)->nullable();  //โอกาสที่จะเกิดขึ้น 
            } 
            if (!Schema::hasColumn('risk_account', 'RISK_ACCOUNT_RISK_EFFECT_ID'))
            {
                $table->String("RISK_ACCOUNT_RISK_EFFECT_ID",255)->nullable();  //ผลกระทบ / ความรุนแรง
            } 
            if (!Schema::hasColumn('risk_account', 'RISK_ACCOUNT_RISK_LEVEL_ID'))
            {
                $table->String("RISK_ACCOUNT_RISK_LEVEL_ID",255)->nullable();  //ระดับความเสี่ยง
            }   
            if (!Schema::hasColumn('risk_account', 'RISK_ACCOUNT_STATUS'))
            {
                $table->String("RISK_ACCOUNT_STATUS",255)->nullable();  //ระดับความเสี่ยง
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
        //
    }
}
