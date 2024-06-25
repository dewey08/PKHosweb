<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdddataRiskAccountRiskeffect extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('risk_account_riskeffect')) {
            DB::table('risk_account_riskeffect')->truncate();
        }
        DB::table('risk_account_riskeffect')->insert(array(
            'RISK_ACCOUNTRISKEFFECT_ID' => '1',
            'RISK_ACCOUNTRISKEFFECT_CODE' => '1', 
            'RISK_ACCOUNTRISKEFFECT_NAME' => '',  
            'RISK_ACCOUNTSCOPE_ID' => '1',         
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_riskeffect')->insert(array(
            'RISK_ACCOUNTRISKEFFECT_ID' => '2',
            'RISK_ACCOUNTRISKEFFECT_CODE' => '2', 
            'RISK_ACCOUNTRISKEFFECT_NAME' => '', 
            'RISK_ACCOUNTSCOPE_ID' => '1',         
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_riskeffect')->insert(array(
            'RISK_ACCOUNTRISKEFFECT_ID' => '3',
            'RISK_ACCOUNTRISKEFFECT_CODE' => '3', 
            'RISK_ACCOUNTRISKEFFECT_NAME' => '', 
            'RISK_ACCOUNTSCOPE_ID' => '1',         
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_riskeffect')->insert(array(
            'RISK_ACCOUNTRISKEFFECT_ID' => '4',
            'RISK_ACCOUNTRISKEFFECT_CODE' => '4', 
            'RISK_ACCOUNTRISKEFFECT_NAME' => '', 
            'RISK_ACCOUNTSCOPE_ID' => '1',         
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_riskeffect')->insert(array(
            'RISK_ACCOUNTRISKEFFECT_ID' => '5',
            'RISK_ACCOUNTRISKEFFECT_CODE' => '5', 
            'RISK_ACCOUNTRISKEFFECT_NAME' => '',
            'RISK_ACCOUNTSCOPE_ID' => '1',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        

        DB::table('risk_account_riskeffect')->insert(array(
            'RISK_ACCOUNTRISKEFFECT_ID' => '6',
            'RISK_ACCOUNTRISKEFFECT_CODE' => '1', 
            'RISK_ACCOUNTRISKEFFECT_NAME' => '',  
            'RISK_ACCOUNTSCOPE_ID' => '2',         
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_riskeffect')->insert(array(
            'RISK_ACCOUNTRISKEFFECT_ID' => '7',
            'RISK_ACCOUNTRISKEFFECT_CODE' => '2', 
            'RISK_ACCOUNTRISKEFFECT_NAME' => '', 
            'RISK_ACCOUNTSCOPE_ID' => '2',         
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_riskeffect')->insert(array(
            'RISK_ACCOUNTRISKEFFECT_ID' => '8',
            'RISK_ACCOUNTRISKEFFECT_CODE' => '3', 
            'RISK_ACCOUNTRISKEFFECT_NAME' => '', 
            'RISK_ACCOUNTSCOPE_ID' => '2',         
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_riskeffect')->insert(array(
            'RISK_ACCOUNTRISKEFFECT_ID' => '9',
            'RISK_ACCOUNTRISKEFFECT_CODE' => '4', 
            'RISK_ACCOUNTRISKEFFECT_NAME' => '', 
            'RISK_ACCOUNTSCOPE_ID' => '2',         
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_riskeffect')->insert(array(
            'RISK_ACCOUNTRISKEFFECT_ID' => '10',
            'RISK_ACCOUNTRISKEFFECT_CODE' => '5', 
            'RISK_ACCOUNTRISKEFFECT_NAME' => '',
            'RISK_ACCOUNTSCOPE_ID' => '2',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));


        DB::table('risk_account_riskeffect')->insert(array(
            'RISK_ACCOUNTRISKEFFECT_ID' => '11',
            'RISK_ACCOUNTRISKEFFECT_CODE' => '1', 
            'RISK_ACCOUNTRISKEFFECT_NAME' => '',  
            'RISK_ACCOUNTSCOPE_ID' => '3',         
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_riskeffect')->insert(array(
            'RISK_ACCOUNTRISKEFFECT_ID' => '12',
            'RISK_ACCOUNTRISKEFFECT_CODE' => '2', 
            'RISK_ACCOUNTRISKEFFECT_NAME' => '', 
            'RISK_ACCOUNTSCOPE_ID' => '3',         
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_riskeffect')->insert(array(
            'RISK_ACCOUNTRISKEFFECT_ID' => '13',
            'RISK_ACCOUNTRISKEFFECT_CODE' => '3', 
            'RISK_ACCOUNTRISKEFFECT_NAME' => '', 
            'RISK_ACCOUNTSCOPE_ID' => '3',         
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_riskeffect')->insert(array(
            'RISK_ACCOUNTRISKEFFECT_ID' => '14',
            'RISK_ACCOUNTRISKEFFECT_CODE' => '4', 
            'RISK_ACCOUNTRISKEFFECT_NAME' => '', 
            'RISK_ACCOUNTSCOPE_ID' => '3',         
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_riskeffect')->insert(array(
            'RISK_ACCOUNTRISKEFFECT_ID' => '15',
            'RISK_ACCOUNTRISKEFFECT_CODE' => '5', 
            'RISK_ACCOUNTRISKEFFECT_NAME' => '',
            'RISK_ACCOUNTSCOPE_ID' => '3',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));


        DB::table('risk_account_riskeffect')->insert(array(
            'RISK_ACCOUNTRISKEFFECT_ID' => '16',
            'RISK_ACCOUNTRISKEFFECT_CODE' => '1', 
            'RISK_ACCOUNTRISKEFFECT_NAME' => '',  
            'RISK_ACCOUNTSCOPE_ID' => '4',         
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_riskeffect')->insert(array(
            'RISK_ACCOUNTRISKEFFECT_ID' => '17',
            'RISK_ACCOUNTRISKEFFECT_CODE' => '2', 
            'RISK_ACCOUNTRISKEFFECT_NAME' => '', 
            'RISK_ACCOUNTSCOPE_ID' => '4',         
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_riskeffect')->insert(array(
            'RISK_ACCOUNTRISKEFFECT_ID' => '18',
            'RISK_ACCOUNTRISKEFFECT_CODE' => '3', 
            'RISK_ACCOUNTRISKEFFECT_NAME' => '', 
            'RISK_ACCOUNTSCOPE_ID' => '4',         
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_riskeffect')->insert(array(
            'RISK_ACCOUNTRISKEFFECT_ID' => '19',
            'RISK_ACCOUNTRISKEFFECT_CODE' => '4', 
            'RISK_ACCOUNTRISKEFFECT_NAME' => '', 
            'RISK_ACCOUNTSCOPE_ID' => '4',         
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_riskeffect')->insert(array(
            'RISK_ACCOUNTRISKEFFECT_ID' => '20',
            'RISK_ACCOUNTRISKEFFECT_CODE' => '5', 
            'RISK_ACCOUNTRISKEFFECT_NAME' => '',
            'RISK_ACCOUNTSCOPE_ID' => '4',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));


        DB::table('risk_account_riskeffect')->insert(array(
            'RISK_ACCOUNTRISKEFFECT_ID' => '21',
            'RISK_ACCOUNTRISKEFFECT_CODE' => '1', 
            'RISK_ACCOUNTRISKEFFECT_NAME' => '',  
            'RISK_ACCOUNTSCOPE_ID' => '5',         
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_riskeffect')->insert(array(
            'RISK_ACCOUNTRISKEFFECT_ID' => '22',
            'RISK_ACCOUNTRISKEFFECT_CODE' => '2', 
            'RISK_ACCOUNTRISKEFFECT_NAME' => '', 
            'RISK_ACCOUNTSCOPE_ID' => '5',         
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_riskeffect')->insert(array(
            'RISK_ACCOUNTRISKEFFECT_ID' => '23',
            'RISK_ACCOUNTRISKEFFECT_CODE' => '3', 
            'RISK_ACCOUNTRISKEFFECT_NAME' => '', 
            'RISK_ACCOUNTSCOPE_ID' => '5',         
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_riskeffect')->insert(array(
            'RISK_ACCOUNTRISKEFFECT_ID' => '24',
            'RISK_ACCOUNTRISKEFFECT_CODE' => '4', 
            'RISK_ACCOUNTRISKEFFECT_NAME' => '', 
            'RISK_ACCOUNTSCOPE_ID' => '5',         
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_riskeffect')->insert(array(
            'RISK_ACCOUNTRISKEFFECT_ID' => '25',
            'RISK_ACCOUNTRISKEFFECT_CODE' => '5', 
            'RISK_ACCOUNTRISKEFFECT_NAME' => '',
            'RISK_ACCOUNTSCOPE_ID' => '5',          
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
