<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdddataRiskRepTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('risk_rep_time')) {
            DB::table('risk_rep_time')->truncate();
        }

        DB::table('risk_rep_time')->insert(array(
            'RISK_TIME_ID' => '1',
            'RISK_TIME_NAME' => 'วันราชการ-เวรดึก (00.01 - 08.00 น. หรือ 00.31-08 น.)',
            'RISK_TIME_START' => '00:01:00',
            'RISK_TIME_END' => '08:00:00',
            'RISK_TIME_COMMENT' => '',
            'RISK_TIME_EXPORT' => '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_time')->insert(array(
            'RISK_TIME_ID' => '2',
            'RISK_TIME_NAME' => 'วันราชการ-เวรเช้า (08.01 - 16.00 น. หรือ 08.31 - 16.30 น.)',
            'RISK_TIME_START' => '08:01:00',
            'RISK_TIME_END' => '16:00:00',
            'RISK_TIME_COMMENT' => '',
            'RISK_TIME_EXPORT' => '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_time')->insert(array(
            'RISK_TIME_ID' => '3',
            'RISK_TIME_NAME' => 'วันราชการ-เวรบ่าย (16.01 - 24.00 น. หรือ 16.31 - 00.30 น.)',
            'RISK_TIME_START' => '16:01:00',
            'RISK_TIME_END' => '24:00:00',
            'RISK_TIME_COMMENT' => '',
            'RISK_TIME_EXPORT' => '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_time')->insert(array(
            'RISK_TIME_ID' => '4',
            'RISK_TIME_NAME' => 'วันหยุดราชการ-เวรดึก (00.01 - 08.00 น. หรือ 00.31 - 00.30 น.)',
            'RISK_TIME_START' => '00:01:00',
            'RISK_TIME_END' => '08:00:00',
            'RISK_TIME_COMMENT' => '',
            'RISK_TIME_EXPORT' => '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_time')->insert(array(
            'RISK_TIME_ID' => '5',
            'RISK_TIME_NAME' => 'วันหยุดราชการ-เวรเช้า (08.01 - 16.00 น. หรือ 08.31 - 16.30 น.)',
            'RISK_TIME_START' => '08:01:00',
            'RISK_TIME_END' => '16:00:00',
            'RISK_TIME_COMMENT' => '',
            'RISK_TIME_EXPORT' => '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_time')->insert(array(
            'RISK_TIME_ID' => '6',
            'RISK_TIME_NAME' => 'วันหยุดราชการ-เวรบ่าย (16.01 - 24.00 น. หรือ 16.31 - 00.30 น.)',
            'RISK_TIME_START' => '16:01:00',
            'RISK_TIME_END' => '24:00:00',
            'RISK_TIME_COMMENT' => '',
            'RISK_TIME_EXPORT' => '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_time')->insert(array(
            'RISK_TIME_ID' => '7',
            'RISK_TIME_NAME' => 'วันหยุดนักขัตฤกษ์-เวรดึก (00.01 - 08.00 น. หรือ 00.31 - 08.30 น.)',
            'RISK_TIME_START' => '00:01:00',
            'RISK_TIME_END' => '08:00:00',
            'RISK_TIME_COMMENT' => '',
            'RISK_TIME_EXPORT' => '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_time')->insert(array(
            'RISK_TIME_ID' => '8',
            'RISK_TIME_NAME' => 'วันหยุดนักขัตฤกษ์-เวรเช้า (08.01 - 16.00 น. หรือ 08.31 - 16.30 น.)',
            'RISK_TIME_START' => '08:01:00',
            'RISK_TIME_END' => '16:00:00',
            'RISK_TIME_COMMENT' => '',
            'RISK_TIME_EXPORT' => '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_time')->insert(array(
            'RISK_TIME_ID' => '9',
            'RISK_TIME_NAME' => 'วันหยุดนักขัตฤกษ์-เวรบ่าย (16.01 - 24.00 น. หรือ 16.31 - 00.30 น.)',
            'RISK_TIME_START' => '16:01:00',
            'RISK_TIME_END' => '24:00:00',
            'RISK_TIME_COMMENT' => '',
            'RISK_TIME_EXPORT' => '',
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
