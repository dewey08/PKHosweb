<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdddataRiskRepProgramSubsub extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('risk_rep_program_subsub')) {
            DB::table('risk_rep_program_subsub')->truncate();
        }
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '1',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.2.1.Acute MI',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '2',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '2',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.2.2.Stoke',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '2',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '3',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.2.3.Sepsis',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '2',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '4',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.3.1.Acute MI',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '3',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '5',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.3.2.Stroke',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '3',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '6',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.3.3.Sepsis',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '3',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '7',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.3.4.Head injury',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '3',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '8',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.7.1.Phlebtis',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '7',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '9',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.7.2.ปฏิกิริยาการให้เลือด',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '7',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '10',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.7.3.ให้โลหิต ผิด ชนิด ผิดหมู่',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '7',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '11',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.7.4.อื่นๆ',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '7',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '12',
            'RISK_REPPROGRAMSUBSUB_NAME' => '3.1.1.CAUTI',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '10',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '13',
            'RISK_REPPROGRAMSUBSUB_NAME' => '3.1.2.Surgical wound',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '10',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '14',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.3.5.Acute abdomen',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '3',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '15',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.1.1.ตัวผู้ป่วย',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '16',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.1.2.สิ่งส่งตรวจ ภาพถ่ายรังสี',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '17',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.3.6.Frature',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '3',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '18',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.3.7.Respiratory failure',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '3',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '19',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.3.8.อื่นๆ',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '3',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '20',
            'RISK_REPPROGRAMSUBSUB_NAME' => '3.3.1.Sharp injury',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '28',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '21',
            'RISK_REPPROGRAMSUBSUB_NAME' => '3.3.2.สิ่งคัดหลั่ง',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '28',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '22',
            'RISK_REPPROGRAMSUBSUB_NAME' => '5.1.1.เครื่องมืออุปกรณ์การแพทย์ที่ใช้ในภาวะฉุกเฉิน',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '15',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '23',
            'RISK_REPPROGRAMSUBSUB_NAME' => '5.1.2.เครื่องมืออุปกรณ์การแพทย์ทั่วไป',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '15',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '24',
            'RISK_REPPROGRAMSUBSUB_NAME' => '5.1.3.เครื่องมือห้องชันสูตร',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '15',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '25',
            'RISK_REPPROGRAMSUBSUB_NAME' => '5.1.4.เครื่องเอกซเรย์',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '15',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '26',
            'RISK_REPPROGRAMSUBSUB_NAME' => '5.2.1.เครื่องมืออุปกรณ์การแพทย์ที่ใช้ในภาวะฉุกเฉิน',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '16',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '27',
            'RISK_REPPROGRAMSUBSUB_NAME' => '5.2.2.เครื่องมืออุปกรณ์การแพทย์ทั่วไป',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '16',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '28',
            'RISK_REPPROGRAMSUBSUB_NAME' => '5.2.3.เครื่องมือห้องชันสูตร',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '16',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '29',
            'RISK_REPPROGRAMSUBSUB_NAME' => '5.2.4.เครื่องเอกซเรย์',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '16',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '30',
            'RISK_REPPROGRAMSUBSUB_NAME' => '5.3.1.เครื่องมืออุปกรณ์การแพทย์ที่ใช้ในภาวะฉุกเฉิน',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '17',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '31',
            'RISK_REPPROGRAMSUBSUB_NAME' => '5.3.2.เครื่องมืออุปกรณ์การแพทย์ทั่วไป',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '17',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '32',
            'RISK_REPPROGRAMSUBSUB_NAME' => '5.3.3.เครื่องมือห้องชันสูตร',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '17',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '33',
            'RISK_REPPROGRAMSUBSUB_NAME' => '5.3.4.เครื่องเอกซเรย์',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '17',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '34',
            'RISK_REPPROGRAMSUBSUB_NAME' => '5.4.1.เครื่องมืออุปกรณ์การแพทย์ที่ใช้ในภาวะฉุกเฉิน',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '18',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '35',
            'RISK_REPPROGRAMSUBSUB_NAME' => '5.4.2.เครื่องมืออุปกรณ์การแพทย์ทั่วไป',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '18',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '36',
            'RISK_REPPROGRAMSUBSUB_NAME' => '5.4.3.เครื่องมือห้องชันสูตร',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '18',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '37',
            'RISK_REPPROGRAMSUBSUB_NAME' => '5.4.4.เครื่องเอกซเรย์',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '18',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '38',
            'RISK_REPPROGRAMSUBSUB_NAME' => '5.5.1.เครื่องมืออุปกรณ์การแพทย์ที่ใช้ในภาวะฉุกเฉิน',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '19',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '39',
            'RISK_REPPROGRAMSUBSUB_NAME' => '5.5.2.เครื่องมืออุปกรณ์การแพทย์ทั่วไป',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '19',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '40',
            'RISK_REPPROGRAMSUBSUB_NAME' => '5.5.3.เครื่องมือห้องชันสูตร',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '19',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '41',
            'RISK_REPPROGRAMSUBSUB_NAME' => '5.5.4.เครื่องเอกซเรย์',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '19',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '42',
            'RISK_REPPROGRAMSUBSUB_NAME' => '6.1.1.แพทย์',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '31',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '43',
            'RISK_REPPROGRAMSUBSUB_NAME' => '6.1.2.พยาบาล',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '31',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '44',
            'RISK_REPPROGRAMSUBSUB_NAME' => '6.1.3.พนักงานขับรถ EMS Refer',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '31',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '45',
            'RISK_REPPROGRAMSUBSUB_NAME' => '6.1.4.เจ้าหน้าที่อื่นๆ',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '31',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '46',
            'RISK_REPPROGRAMSUBSUB_NAME' => '7.3.1.เวชระเบียน',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '38',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '47',
            'RISK_REPPROGRAMSUBSUB_NAME' => '7.3.2.ใบนัด',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '38',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '48',
            'RISK_REPPROGRAMSUBSUB_NAME' => '7.3.3.ใบส่งตัว',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '38',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '49',
            'RISK_REPPROGRAMSUBSUB_NAME' => '7.3.4.ใบรับรองแพทย์ ใบรับรองการตาย',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '38',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '50',
            'RISK_REPPROGRAMSUBSUB_NAME' => '7.4.1.ไม่ครบถ้วน สูญหาย',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '39',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '51',
            'RISK_REPPROGRAMSUBSUB_NAME' => '7.4.2.Scan เอกสารผิดคน',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '39',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '52',
            'RISK_REPPROGRAMSUBSUB_NAME' => '7.4.3.Scan เอกสารไม่ชัด',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '39',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '53',
            'RISK_REPPROGRAMSUBSUB_NAME' => '7.4.4.เปิดดูไม่ได้',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '39',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '54',
            'RISK_REPPROGRAMSUBSUB_NAME' => '7.5.1.HOSxP ',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '40',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '55',
            'RISK_REPPROGRAMSUBSUB_NAME' => '7.5.2.LIS',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '40',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '56',
            'RISK_REPPROGRAMSUBSUB_NAME' => '7.5.3.Xray',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '40',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '57',
            'RISK_REPPROGRAMSUBSUB_NAME' => '7.5.4.BACKOFFICE',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '40',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '58',
            'RISK_REPPROGRAMSUBSUB_NAME' => '7.7.1.Hardware',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '42',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '59',
            'RISK_REPPROGRAMSUBSUB_NAME' => '7.7.2.Software',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '42',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '60',
            'RISK_REPPROGRAMSUBSUB_NAME' => '7.7.3.Network Switck Hub',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '42',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '61',
            'RISK_REPPROGRAMSUBSUB_NAME' => '8.2.1.เปิดเผยความลับของผู้ป่วย',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '45',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '62',
            'RISK_REPPROGRAMSUBSUB_NAME' => '8.2.2.เปิดเผยร่างกายของผู้ป่วย',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '45',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '63',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.1.1.ผิดชนิด',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '8',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '64',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.1.2.ผิดคน',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '8',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '65',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.1.3.รายการยาไม่ครบถ้วน',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '8',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '66',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.1.4.ผิดจำนวน',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '8',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '67',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.1.5.สั่งยาผิดขนาด',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '8',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '68',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.1.6.สั่งยาที่ไม่ควรได้รับ(มีข้อห้าม,มี Drug interaction)',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '8',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '69',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.1.7.สั่งยาซ้ำซ้อน',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '8',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '70',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.1.8.สั่งยาที่มีประวัติแพ้',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '8',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '71',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.1.9.สั่งยาในรูปแบบที่ไม่เหมาะสม',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '8',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '72',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.1.10.เขียนคำสั่งใช้ยาไม่ชัดเจน (อ่านไม่ออก,เขียน-คีย์ไม่ตรงกัน)',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '8',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '73',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.1.11.ไม่ระบุวิธีใช้',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '8',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '74',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.1.12.ไม่ระบุความแรง/ผิดความแรง',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '8',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '75',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.1.13.ฉลากยาไม่ถูกต้อง',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '8',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '76',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.1.14.ใช้คำย่อไม่เป็นสากล หรือตามมาตรฐานโรงพยาบาล',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '8',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '77',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.5.1.ผิดชนิด',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '26',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '78',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.5.2.ผิดจำนวน',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '26',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '79',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.5.3.ผิดความแรง',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '26',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '80',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.5.4.จับคู่ใบสั่งยาผิดคน',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '26',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '81',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.5.5.ฉีกฉลากยาปนกัน',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '26',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '82',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.5.6.ติดชื่อผิด',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '26',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '83',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.5.7.จัดยาไม่ครบรายการ',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '26',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '84',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.5.8.อื่นๆ',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '26',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '85',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.4.1.ผิดชนิด',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '25',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '86',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.4.2.ผิดขนาด(จำนวน ความแรง ความเข้มข้น)',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '25',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '87',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.4.3.ผิดคน',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '25',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '88',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.4.4.ผิดวิธีการบริหารยา',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '25',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '89',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.4.5.ให้ยาผิดเวลา (เกินไปมากกว่า 1 ชั่วโมง)',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '25',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '90',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.4.6.ไม่ได้ให้ยาที่แพทย์สั่ง',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '25',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '91',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.4.7.ให้ยาที่แพทย์ไม่ได้สั่งใช้',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '25',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '92',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.4.8.ให้ยาที่ทราบว่าแพ้',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '25',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '93',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.4.9.ให้ยาที่มีข้อห้าม',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '25',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '94',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.4.10.ให้ยาผิดเทคนิค (เช่น สารละลายไม่เหมาะสม อัตราเร็วผิด)',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '25',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '95',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.2.1.ผิดชนิด',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '9',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '96',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.2.2.ผิดจำนวน',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '9',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '97',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.2.3.ผิดความแรง',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '9',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '98',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.2.4.ผิดคน',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '9',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '99',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.2.5.ผิดวิธีการบริหารยา',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '9',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '100',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.2.6.รายการยาไม่ครบถ้วน',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '9',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '101',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.2.7.รายการยาเกินที่สั่งใช้',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '9',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '102',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.2.8.ฉลากยาไม่ถูกต้อง',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '9',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '103',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.2.9.อื่นๆ',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '9',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '104',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.3.1.ผิดชนิด',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '24',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '105',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.3.2.ผิดจำนวน',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '24',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '106',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.3.3.ผิดความแรง',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '24',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '107',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.3.4.ผิดคน,ฉลากยาผิดคน',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '24',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '108',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.3.5.ผิดวิธีการบริหารยา',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '24',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '109',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.3.6.จ่ายยาไม่ครบรายการ,เกินรายการที่สั่งใช้',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '24',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '110',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.3.7.จ่ายยาที่มีประวัติแพ้',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '24',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '111',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.3.8.จ่ายยาที่มีปฏิกิริยาต่อกันระดับ',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '24',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '112',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.3.9.จ่ายยาที่เสื่อมสภาพ หมดอายุ',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '24',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '113',
            'RISK_REPPROGRAMSUBSUB_NAME' => '2.3.10.จ่ายยาแล้วไม่ให้คำแนะนำที่เหมาะสม',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '24',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '114',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.2.4.Head injury',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '2',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '115',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.2.5.Acute abdomen',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '2',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '116',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.2.6.Fracture',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '2',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '117',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.2.7.Respiratory failure',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '2',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '118',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.2.8.อื่นๆ',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '2',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '119',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.5.1.PPH with shock',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '5',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '120',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.5.2.Eclampsia',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '5',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '121',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.5.3.Third degree tear',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '5',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '122',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.5.4.Birth injury',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '5',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '123',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.5.5.อื่นๆ',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '5',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '124',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.6.1.Bleeding',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '6',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '125',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.6.2.Injury',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '6',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '126',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.6.3.แผลแยก',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '6',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '127',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.6.4.ผิดคน ผิดตำแหน่ง',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '6',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '128',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.6.5.Hypotension',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '6',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '129',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.6.6.High block SA',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '6',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '130',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.6.7.อื่นๆ',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '6',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '131',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.8.1.Bleeding',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '22',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '132',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.8.2.Infection',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '22',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '133',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.8.3.บาดเจ็บจากการใช้เครื่องมือ',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '22',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '134',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.8.4.อื่นๆ',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '22',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '135',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.9.1.บาดเจ็บจากการใช้เครื่องมือในการรักษา ผูกมัด เคลื่อนย้าย',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '23',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '136',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.9.2.Iatrogenic pneumothorax',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '23',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '137',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.9.3.แผลกดทับ',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '23',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '138',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.9.4.Hypoglycemia',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '23',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '139',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.9.5.อื่นๆ',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '23',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '140',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.10.1.เสียชีวิต',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '54',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '141',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.10.2.ส่งต่อไปสถานพยาบาลที่สูงกว่า',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '54',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '142',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.10.3.CPR',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '54',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '143',
            'RISK_REPPROGRAMSUBSUB_NAME' => '3.1.3.Episiotomy',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '10',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '144',
            'RISK_REPPROGRAMSUBSUB_NAME' => '3.1.4.pneumonia',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '10',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '145',
            'RISK_REPPROGRAMSUBSUB_NAME' => '3.1.5.บุคลากรติดเชื้อจากการทำงาน',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '10',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '146',
            'RISK_REPPROGRAMSUBSUB_NAME' => '3.4.1.ใช้เครื่องป้องกันไม่เหมาะสม',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '29',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '147',
            'RISK_REPPROGRAMSUBSUB_NAME' => '3.4.2.การล้างมือไม่ถูกต้อง',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '29',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '148',
            'RISK_REPPROGRAMSUBSUB_NAME' => '3.4.3.การแยกผู้ป่วยไม่ถูกต้อง',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '29',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '149',
            'RISK_REPPROGRAMSUBSUB_NAME' => '3.4.4.การทิ้งขยะผิดประเภท',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '29',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '150',
            'RISK_REPPROGRAMSUBSUB_NAME' => '3.4.5.การทิ้งของมีคมผิดวิธี',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '29',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '151',
            'RISK_REPPROGRAMSUBSUB_NAME' => '3.4.6.อื่นๆ',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '29',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '152',
            'RISK_REPPROGRAMSUBSUB_NAME' => '4.9.1.ระบบออกซิเจน',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '62',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '153',
            'RISK_REPPROGRAMSUBSUB_NAME' => '4.9.2.ระบบไฟฟ้า',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '62',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '154',
            'RISK_REPPROGRAMSUBSUB_NAME' => '4.9.3.ระบบบำบัดน้ำเสีย/กำจัดขยะ',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '62',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '155',
            'RISK_REPPROGRAMSUBSUB_NAME' => '4.9.4.น้ำดื่มน้ำประปา',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '62',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '156',
            'RISK_REPPROGRAMSUBSUB_NAME' => '7.1.1.สูญหาย/หาไม่พบ',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '36',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '157',
            'RISK_REPPROGRAMSUBSUB_NAME' => '7.1.2.สลับคน',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '36',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '158',
            'RISK_REPPROGRAMSUBSUB_NAME' => '7.2.1.สูญหาย/หาไม่พบ',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '37',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '159',
            'RISK_REPPROGRAMSUBSUB_NAME' => '7.2.2.สลับคน',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '37',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '160',
            'RISK_REPPROGRAMSUBSUB_NAME' => '7.2.3.บันทึกผิดพลาด',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '37',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '161',
            'RISK_REPPROGRAMSUBSUB_NAME' => '7.5.5.อื่นๆ',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '40',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '162',
            'RISK_REPPROGRAMSUBSUB_NAME' => '8.2.3.ไม่ขอคำยินยอมก่อนให้การรักษา หัตถการ',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '45',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '163',
            'RISK_REPPROGRAMSUBSUB_NAME' => '8.2.4.อื่นๆ',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '45',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '164',
            'RISK_REPPROGRAMSUBSUB_NAME' => '1.8.5 รักษาผิดตำแหน่ง',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '22',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '165',
            'RISK_REPPROGRAMSUBSUB_NAME' => '4.7.1 รถrefer ชำรุด ขัดข้องไม่พร้อมใช้',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '60',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '166',
            'RISK_REPPROGRAMSUBSUB_NAME' => '4.7.3 รถเข็นไฟฟ้า ชำรุด ขัดข้อง ไม่พร้อมใช้',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '60',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '167',
            'RISK_REPPROGRAMSUBSUB_NAME' => '4.7.4 รถเข็น เปลนอน ขัดข้อง ชำรุด ไม่เพียงพอ',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '60',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '168',
            'RISK_REPPROGRAMSUBSUB_NAME' => '4.7.5 เกิดอุบัติเหตุจราจร',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '60',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '169',
            'RISK_REPPROGRAMSUBSUB_NAME' => '4.7.8 อื่นๆ',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '60',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '170',
            'RISK_REPPROGRAMSUBSUB_NAME' => '4.7.6 พนักงานขับรถไม่พร้อมปฏิบัติงาน',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '60',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '171',
            'RISK_REPPROGRAMSUBSUB_NAME' => '4.7.7 ขับรถผิดกฏจราจร ใช้ความเร็วเกินกำหนด ',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '60',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '172',
            'RISK_REPPROGRAMSUBSUB_NAME' => '4.7.2 รถยนต์ ชำรุด ขัดข้อง ไม่พร้อมใช้',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '60',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_subsub')->insert(array(
            'RISK_REPPROGRAMSUBSUB_ID' => '173',
            'RISK_REPPROGRAMSUBSUB_NAME' => '5.1.5 เครื่องมือทำให้ปราศจากเชื้อ',
            'RISK_REPPROGRAMSUBSUB_DETAIL' => '',
            'RISK_REPPROGRAMSUB_ID' => '15',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
    }

    /** ////// ถึง 364
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
