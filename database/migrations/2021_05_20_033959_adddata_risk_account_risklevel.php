<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdddataRiskAccountRisklevel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('risk_account_risk_level')) {
            DB::table('risk_account_risk_level')->truncate();
        }
        DB::table('risk_account_risk_level')->insert(array(
            'RISK_ACCOUNTRISKLEVEL_ID' => '1',
            'RISK_ACCOUNTRISKLEVEL_CODE' => '1', 
            'RISK_ACCOUNTRISKLEVEL_NAME' => '(น้อยที่สุด)',  
            'RISK_ACCOUNTSCOPE_ID' => '1',  
            'RISK_ACCOUNTRISKEFFECT_ID' => '1',         
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_risk_level')->insert(array(
            'RISK_ACCOUNTRISKLEVEL_ID' => '2',
            'RISK_ACCOUNTRISKLEVEL_CODE' => '2', 
            'RISK_ACCOUNTRISKLEVEL_NAME' => '(น้อยที่สุด)', 
            'RISK_ACCOUNTSCOPE_ID' => '1', 
            'RISK_ACCOUNTRISKEFFECT_ID' => '2',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_risk_level')->insert(array(
            'RISK_ACCOUNTRISKLEVEL_ID' => '3',
            'RISK_ACCOUNTRISKLEVEL_CODE' => '3', 
            'RISK_ACCOUNTRISKLEVEL_NAME' => '(น้อยที่สุด)', 
            'RISK_ACCOUNTSCOPE_ID' => '1',  
            'RISK_ACCOUNTRISKEFFECT_ID' => '3',       
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_risk_level')->insert(array(
            'RISK_ACCOUNTRISKLEVEL_ID' => '4',
            'RISK_ACCOUNTRISKLEVEL_CODE' => '4', 
            'RISK_ACCOUNTRISKLEVEL_NAME' => '(น้อยที่สุด)', 
            'RISK_ACCOUNTSCOPE_ID' => '1', 
            'RISK_ACCOUNTRISKEFFECT_ID' => '4',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_risk_level')->insert(array(
            'RISK_ACCOUNTRISKLEVEL_ID' => '5',
            'RISK_ACCOUNTRISKLEVEL_CODE' => '5', 
            'RISK_ACCOUNTRISKLEVEL_NAME' => '(น้อย)',
            'RISK_ACCOUNTSCOPE_ID' => '1',  
            'RISK_ACCOUNTRISKEFFECT_ID' => '5',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));

        DB::table('risk_account_risk_level')->insert(array(
            'RISK_ACCOUNTRISKLEVEL_ID' => '6',
            'RISK_ACCOUNTRISKLEVEL_CODE' => '2', 
            'RISK_ACCOUNTRISKLEVEL_NAME' => '(น้อยที่สุด)',  
            'RISK_ACCOUNTSCOPE_ID' => '2',  
            'RISK_ACCOUNTRISKEFFECT_ID' => '6',         
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_risk_level')->insert(array(
            'RISK_ACCOUNTRISKLEVEL_ID' => '7',
            'RISK_ACCOUNTRISKLEVEL_CODE' => '4', 
            'RISK_ACCOUNTRISKLEVEL_NAME' => '(น้อยที่สุด)', 
            'RISK_ACCOUNTSCOPE_ID' => '2', 
            'RISK_ACCOUNTRISKEFFECT_ID' => '7',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_risk_level')->insert(array(
            'RISK_ACCOUNTRISKLEVEL_ID' => '8',
            'RISK_ACCOUNTRISKLEVEL_CODE' => '6', 
            'RISK_ACCOUNTRISKLEVEL_NAME' => '(น้อย)', 
            'RISK_ACCOUNTSCOPE_ID' => '2',  
            'RISK_ACCOUNTRISKEFFECT_ID' => '8',       
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_risk_level')->insert(array(
            'RISK_ACCOUNTRISKLEVEL_ID' => '9',
            'RISK_ACCOUNTRISKLEVEL_CODE' => '8', 
            'RISK_ACCOUNTRISKLEVEL_NAME' => '(น้อย)', 
            'RISK_ACCOUNTSCOPE_ID' => '2', 
            'RISK_ACCOUNTRISKEFFECT_ID' => '9',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_risk_level')->insert(array(
            'RISK_ACCOUNTRISKLEVEL_ID' => '10',
            'RISK_ACCOUNTRISKLEVEL_CODE' => '10', 
            'RISK_ACCOUNTRISKLEVEL_NAME' => '(ปานกลาง)',
            'RISK_ACCOUNTSCOPE_ID' => '2',  
            'RISK_ACCOUNTRISKEFFECT_ID' => '10',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));

        DB::table('risk_account_risk_level')->insert(array(
            'RISK_ACCOUNTRISKLEVEL_ID' => '11',
            'RISK_ACCOUNTRISKLEVEL_CODE' => '3', 
            'RISK_ACCOUNTRISKLEVEL_NAME' => '(น้อยที่สุด)',  
            'RISK_ACCOUNTSCOPE_ID' => '3',  
            'RISK_ACCOUNTRISKEFFECT_ID' => '11',         
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_risk_level')->insert(array(
            'RISK_ACCOUNTRISKLEVEL_ID' => '12',
            'RISK_ACCOUNTRISKLEVEL_CODE' => '6', 
            'RISK_ACCOUNTRISKLEVEL_NAME' => '(น้อย)', 
            'RISK_ACCOUNTSCOPE_ID' => '3', 
            'RISK_ACCOUNTRISKEFFECT_ID' => '12',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_risk_level')->insert(array(
            'RISK_ACCOUNTRISKLEVEL_ID' => '13',
            'RISK_ACCOUNTRISKLEVEL_CODE' => '9', 
            'RISK_ACCOUNTRISKLEVEL_NAME' => '(น้อย)', 
            'RISK_ACCOUNTSCOPE_ID' => '3',  
            'RISK_ACCOUNTRISKEFFECT_ID' => '13',       
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_risk_level')->insert(array(
            'RISK_ACCOUNTRISKLEVEL_ID' => '14',
            'RISK_ACCOUNTRISKLEVEL_CODE' => '12', 
            'RISK_ACCOUNTRISKLEVEL_NAME' => '(ปานกลาง)', 
            'RISK_ACCOUNTSCOPE_ID' => '3', 
            'RISK_ACCOUNTRISKEFFECT_ID' => '14',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_risk_level')->insert(array(
            'RISK_ACCOUNTRISKLEVEL_ID' => '15',
            'RISK_ACCOUNTRISKLEVEL_CODE' => '15', 
            'RISK_ACCOUNTRISKLEVEL_NAME' => '(สูง)',
            'RISK_ACCOUNTSCOPE_ID' => '3',  
            'RISK_ACCOUNTRISKEFFECT_ID' => '15',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));

        DB::table('risk_account_risk_level')->insert(array(
            'RISK_ACCOUNTRISKLEVEL_ID' => '16',
            'RISK_ACCOUNTRISKLEVEL_CODE' => '4', 
            'RISK_ACCOUNTRISKLEVEL_NAME' => '(น้อยที่สุด)',  
            'RISK_ACCOUNTSCOPE_ID' => '4',  
            'RISK_ACCOUNTRISKEFFECT_ID' => '16',         
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_risk_level')->insert(array(
            'RISK_ACCOUNTRISKLEVEL_ID' => '17',
            'RISK_ACCOUNTRISKLEVEL_CODE' => '8', 
            'RISK_ACCOUNTRISKLEVEL_NAME' => '(น้อย)', 
            'RISK_ACCOUNTSCOPE_ID' => '4', 
            'RISK_ACCOUNTRISKEFFECT_ID' => '17',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_risk_level')->insert(array(
            'RISK_ACCOUNTRISKLEVEL_ID' => '18',
            'RISK_ACCOUNTRISKLEVEL_CODE' => '12', 
            'RISK_ACCOUNTRISKLEVEL_NAME' => '(ปานกลาง)', 
            'RISK_ACCOUNTSCOPE_ID' => '4',  
            'RISK_ACCOUNTRISKEFFECT_ID' => '18',       
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_risk_level')->insert(array(
            'RISK_ACCOUNTRISKLEVEL_ID' => '19',
            'RISK_ACCOUNTRISKLEVEL_CODE' => '16', 
            'RISK_ACCOUNTRISKLEVEL_NAME' => '(สูง)', 
            'RISK_ACCOUNTSCOPE_ID' => '4', 
            'RISK_ACCOUNTRISKEFFECT_ID' => '19',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_risk_level')->insert(array(
            'RISK_ACCOUNTRISKLEVEL_ID' => '20',
            'RISK_ACCOUNTRISKLEVEL_CODE' => '20', 
            'RISK_ACCOUNTRISKLEVEL_NAME' => '(สูงมาก)',
            'RISK_ACCOUNTSCOPE_ID' => '4',  
            'RISK_ACCOUNTRISKEFFECT_ID' => '20',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));

        DB::table('risk_account_risk_level')->insert(array(
            'RISK_ACCOUNTRISKLEVEL_ID' => '21',
            'RISK_ACCOUNTRISKLEVEL_CODE' => '5', 
            'RISK_ACCOUNTRISKLEVEL_NAME' => '(น้อย)',  
            'RISK_ACCOUNTSCOPE_ID' => '5',  
            'RISK_ACCOUNTRISKEFFECT_ID' => '21',         
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_risk_level')->insert(array(
            'RISK_ACCOUNTRISKLEVEL_ID' => '22',
            'RISK_ACCOUNTRISKLEVEL_CODE' => '10', 
            'RISK_ACCOUNTRISKLEVEL_NAME' => '(ปานกลาง)', 
            'RISK_ACCOUNTSCOPE_ID' => '5', 
            'RISK_ACCOUNTRISKEFFECT_ID' => '22',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_risk_level')->insert(array(
            'RISK_ACCOUNTRISKLEVEL_ID' => '23',
            'RISK_ACCOUNTRISKLEVEL_CODE' => '15', 
            'RISK_ACCOUNTRISKLEVEL_NAME' => '(สูง)', 
            'RISK_ACCOUNTSCOPE_ID' => '5',  
            'RISK_ACCOUNTRISKEFFECT_ID' => '23',       
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_risk_level')->insert(array(
            'RISK_ACCOUNTRISKLEVEL_ID' => '24',
            'RISK_ACCOUNTRISKLEVEL_CODE' => '20', 
            'RISK_ACCOUNTRISKLEVEL_NAME' => '(สูงมาก)', 
            'RISK_ACCOUNTSCOPE_ID' => '5', 
            'RISK_ACCOUNTRISKEFFECT_ID' => '24',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_risk_level')->insert(array(
            'RISK_ACCOUNTRISKLEVEL_ID' => '25',
            'RISK_ACCOUNTRISKLEVEL_CODE' => '25', 
            'RISK_ACCOUNTRISKLEVEL_NAME' => '(สูงมาก)',
            'RISK_ACCOUNTSCOPE_ID' => '5',  
            'RISK_ACCOUNTRISKEFFECT_ID' => '25',        
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
