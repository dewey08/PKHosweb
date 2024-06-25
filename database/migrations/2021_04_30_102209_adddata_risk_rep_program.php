<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdddataRiskRepProgram extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('risk_rep_program')) {
            DB::table('risk_rep_program')->truncate();
        }

        DB::table('risk_rep_program')->insert(array(
            'RISK_REPPROGRAM_ID' => '1',
            'RISK_REPPROGRAM_NAME' => '1.โปรแกรมการดูแลรักษา',
            'RISK_REPPROGRAM_DETAIL' => '',
            'RISK_REPPROGRAM_CLINICTYPE_ID' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program')->insert(array(
            'RISK_REPPROGRAM_ID' => '2',
            'RISK_REPPROGRAM_NAME' => '2.โปรแกรมความคลาดเคลื่อนทางยา',
            'RISK_REPPROGRAM_DETAIL' => '',
            'RISK_REPPROGRAM_CLINICTYPE_ID' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program')->insert(array(
            'RISK_REPPROGRAM_ID' => '3',
            'RISK_REPPROGRAM_NAME' => '3.โปรแกรมการควบคุมและป้องกันการติดเชื้อในโรงพยาบาล',
            'RISK_REPPROGRAM_DETAIL' => '',
            'RISK_REPPROGRAM_CLINICTYPE_ID' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program')->insert(array(
            'RISK_REPPROGRAM_ID' => '4',
            'RISK_REPPROGRAM_NAME' => '4.โปรแกรมสิ่งแวดล้อม ความปลอดภัย สาธารณูปโภค',
            'RISK_REPPROGRAM_DETAIL' => '',
            'RISK_REPPROGRAM_CLINICTYPE_ID' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program')->insert(array(
            'RISK_REPPROGRAM_ID' => '5',
            'RISK_REPPROGRAM_NAME' => '5.โปรแกรมด้านเครื่องมือ อุปกรณ์การแพทย์',
            'RISK_REPPROGRAM_DETAIL' => '',
            'RISK_REPPROGRAM_CLINICTYPE_ID' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program')->insert(array(
            'RISK_REPPROGRAM_ID' => '6',
            'RISK_REPPROGRAM_NAME' => '6.โปรแกรมด้านการติดต่อสื่อสาร ประสานงาน',
            'RISK_REPPROGRAM_DETAIL' => '',
            'RISK_REPPROGRAM_CLINICTYPE_ID' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program')->insert(array(
            'RISK_REPPROGRAM_ID' => '7',
            'RISK_REPPROGRAM_NAME' => '7.โปรแกรมระบบข้อมูลการดูแลรักษาและเทคโนโลยีสารสนเทศ',
            'RISK_REPPROGRAM_DETAIL' => '',
            'RISK_REPPROGRAM_CLINICTYPE_ID' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program')->insert(array(
            'RISK_REPPROGRAM_ID' => '8',
            'RISK_REPPROGRAM_NAME' => '8.ระบบบริการอื่นๆ และสิทธิผู้ป่วย',
            'RISK_REPPROGRAM_DETAIL' => '',
            'RISK_REPPROGRAM_CLINICTYPE_ID' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program')->insert(array(
            'RISK_REPPROGRAM_ID' => '9',
            'RISK_REPPROGRAM_NAME' => '9.การเงินและพัสดุ การจัดเก็บรายได้',
            'RISK_REPPROGRAM_DETAIL' => '',
            'RISK_REPPROGRAM_CLINICTYPE_ID' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program')->insert(array(
            'RISK_REPPROGRAM_ID' => '10',
            'RISK_REPPROGRAM_NAME' => '10.ความเสี่ยงด้านอื่นๆ',
            'RISK_REPPROGRAM_DETAIL' => '',
            'RISK_REPPROGRAM_CLINICTYPE_ID' => '1',
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
