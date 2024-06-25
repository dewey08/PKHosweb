<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdddataRiskAccountType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('risk_account_type')) {
            DB::table('risk_account_type')->truncate();
        }
        DB::table('risk_account_type')->insert(array(
            'RISK_ACCOUNTTYPE_ID' => '1',
            'RISK_ACCOUNTTYPE_CODE' => 'RA1001', 
            'RISK_ACCOUNTTYPE_NAME' => 'ด้านกลยุทธ์ (Strategic Risk)',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_type')->insert(array(
            'RISK_ACCOUNTTYPE_ID' => '2',
            'RISK_ACCOUNTTYPE_CODE' => 'RA1002', 
            'RISK_ACCOUNTTYPE_NAME' => 'ด้านการเงิน (Financial Risk)',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_type')->insert(array(
            'RISK_ACCOUNTTYPE_ID' => '3',
            'RISK_ACCOUNTTYPE_CODE' => 'RA1003', 
            'RISK_ACCOUNTTYPE_NAME' => 'ด้านการปฎิบัติงาน (Operational Risk)',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_type')->insert(array(
            'RISK_ACCOUNTTYPE_ID' => '4',
            'RISK_ACCOUNTTYPE_CODE' => 'RA1004', 
            'RISK_ACCOUNTTYPE_NAME' => 'ด้านนโยบาย/กฎหมาย/ระเบียบ/ข้อบังคับ (Policy and Compliance Risk)',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_type')->insert(array(
            'RISK_ACCOUNTTYPE_ID' => '5',
            'RISK_ACCOUNTTYPE_CODE' => 'RA1005', 
            'RISK_ACCOUNTTYPE_NAME' => 'ด้านภาพลักษณ์และชื่อเสียง (Image and Reputation Risk)',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_type')->insert(array(
            'RISK_ACCOUNTTYPE_ID' => '6',
            'RISK_ACCOUNTTYPE_CODE' => 'RA1006', 
            'RISK_ACCOUNTTYPE_NAME' => 'ด้านสิ่งแวดล้อม (Environment Risk)',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_account_type')->insert(array(
            'RISK_ACCOUNTTYPE_ID' => '7',
            'RISK_ACCOUNTTYPE_CODE' => 'RA1007', 
            'RISK_ACCOUNTTYPE_NAME' => 'ด้านสุขภาพ (Healthy Risk)',          
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
