<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailRiskStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_status', function (Blueprint $table) {
            //
        });


        if (Schema::hasTable('risk_status')) {
            DB::table('risk_status')->truncate();
        }

        DB::table('risk_status')->insert(array(
            'RISK_STATUS_ID' => '1',
            'RISK_STATUS_NAME' => 'REPORT',
            'RISK_STATUS_NAME_TH' => 'รายงาน',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_status')->insert(array(
            'RISK_STATUS_ID' => '2',
            'RISK_STATUS_NAME' => 'CHECK',
            'RISK_STATUS_NAME_TH' => 'ตรวจสอบ',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_status')->insert(array(
            'RISK_STATUS_ID' => '3',
            'RISK_STATUS_NAME' => 'CHECKOK',
            'RISK_STATUS_NAME_TH' => 'ยืนยันความเสี่ยง',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_status')->insert(array(
            'RISK_STATUS_ID' => '4',
            'RISK_STATUS_NAME' => 'SUCCESS',
            'RISK_STATUS_NAME_TH' => 'สรุปรายงาน',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_status')->insert(array(
            'RISK_STATUS_ID' => '5',
            'RISK_STATUS_NAME' => 'CANCEL',
            'RISK_STATUS_NAME_TH' => 'ยกเลิกรายงาน',
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
        Schema::table('risk_status', function (Blueprint $table) {
            //
        });
    }
}
