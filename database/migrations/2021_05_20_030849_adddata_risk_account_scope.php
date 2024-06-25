<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdddataRiskAccountScope extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('risk_account_scope')) {
            DB::table('risk_account_scope')->truncate();
        }
        DB::table('risk_account_scope')->insert(array(
            'RISK_ACCOUNTSCOPE_ID' => '1',
            'RISK_ACCOUNTSCOPE_CODE' => '1', 
            'RISK_ACCOUNTSCOPE_NAME' => '',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_scope')->insert(array(
            'RISK_ACCOUNTSCOPE_ID' => '2',
            'RISK_ACCOUNTSCOPE_CODE' => '2', 
            'RISK_ACCOUNTSCOPE_NAME' => '',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_scope')->insert(array(
            'RISK_ACCOUNTSCOPE_ID' => '3',
            'RISK_ACCOUNTSCOPE_CODE' => '3', 
            'RISK_ACCOUNTSCOPE_NAME' => '',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_scope')->insert(array(
            'RISK_ACCOUNTSCOPE_ID' => '4',
            'RISK_ACCOUNTSCOPE_CODE' => '4', 
            'RISK_ACCOUNTSCOPE_NAME' => '',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_scope')->insert(array(
            'RISK_ACCOUNTSCOPE_ID' => '5',
            'RISK_ACCOUNTSCOPE_CODE' => '5', 
            'RISK_ACCOUNTSCOPE_NAME' => '',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
       
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
