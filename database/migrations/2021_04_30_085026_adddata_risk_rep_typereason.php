<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdddataRiskRepTypereason extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('risk_rep_typereason')) {
            DB::table('risk_rep_typereason')->truncate();
        }

        DB::table('risk_rep_typereason')->insert(array(
            'RISK_REPTYPERESON_ID' => '1',
            'RISK_REPTYPERESON_NAME' => 'ผู้ป่วย',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_typereason')->insert(array(
            'RISK_REPTYPERESON_ID' => '2',
            'RISK_REPTYPERESON_NAME' => 'เจ้าหน้าที่',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_typereason')->insert(array(
            'RISK_REPTYPERESON_ID' => '3',
            'RISK_REPTYPERESON_NAME' => 'ทีมงาน',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_typereason')->insert(array(
            'RISK_REPTYPERESON_ID' => '4',
            'RISK_REPTYPERESON_NAME' => 'กระบวนการทำงาน',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_typereason')->insert(array(
            'RISK_REPTYPERESON_ID' => '5',
            'RISK_REPTYPERESON_NAME' => 'เครื่องมือ',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_typereason')->insert(array(
            'RISK_REPTYPERESON_ID' => '6',
            'RISK_REPTYPERESON_NAME' => 'สิ่งแวดล้อม',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_typereason')->insert(array(
            'RISK_REPTYPERESON_ID' => '7',
            'RISK_REPTYPERESON_NAME' => 'ปัจจัยภายนอกที่ควบคุมไม่ได้',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_typereason')->insert(array(
            'RISK_REPTYPERESON_ID' => '8',
            'RISK_REPTYPERESON_NAME' => 'อื่นฯ',
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
