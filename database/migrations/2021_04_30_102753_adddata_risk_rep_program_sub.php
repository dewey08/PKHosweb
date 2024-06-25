<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdddataRiskRepProgramSub extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('risk_rep_program_sub')) {
            DB::table('risk_rep_program_sub')->truncate();
        }

        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '1',
            'RISK_REPPROGRAMSUB_NAME' => '1.1.การบ่งชี้ผู้ป่วยผิดพลาด',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '2',
            'RISK_REPPROGRAMSUB_NAME' => '1.2.การคัดกรอง/ประเมินผิดพลาด ล่าช้า',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '3',
            'RISK_REPPROGRAMSUB_NAME' => '1.3.วินิจฉัยรักษาผิดพลาด ล่าช้า',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '4',
            'RISK_REPPROGRAMSUB_NAME' => '1.4.Revisit โรคเดิมใน 48 ชม.และทรุดลง',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '5',
            'RISK_REPPROGRAMSUB_NAME' => '1.5.ภาวะแทรกซ้อนจาก การคลอด',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '6',
            'RISK_REPPROGRAMSUB_NAME' => '1.6.ภาวะแทรกซ้อนจากการผ่าตัด/ระงับความรู้สึก',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '7',
            'RISK_REPPROGRAMSUB_NAME' => '1.7.ภาวะแทรกซ้อนจากการให้โลหิต ยาและสารน้ำ',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '8',
            'RISK_REPPROGRAMSUB_NAME' => '2.1.Prescribing',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '2',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '9',
            'RISK_REPPROGRAMSUB_NAME' => '2.2.Transcribing',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '2',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '10',
            'RISK_REPPROGRAMSUB_NAME' => '3.1.การติดเชื้อในโรงพยาบาล(ความเสี่ยงทางคลินิก)',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '3',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '11',
            'RISK_REPPROGRAMSUB_NAME' => '4.1.ลื่น, ล้ม, ชน',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '4',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '12',
            'RISK_REPPROGRAMSUB_NAME' => '4.2.ตกจากเตียง เปล โต๊ะ',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '4',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '13',
            'RISK_REPPROGRAMSUB_NAME' => '4.3.บาดเจ็บจากที่ทำงาน',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '4',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '14',
            'RISK_REPPROGRAMSUB_NAME' => '4.4.อันตรายจากรังสี',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '4',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '15',
            'RISK_REPPROGRAMSUB_NAME' => '5.1.ไม่พร้อมใช้',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '5',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '16',
            'RISK_REPPROGRAMSUB_NAME' => '5.2.ขัดข้อง ทำงานผิดปกติ',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '5',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '17',
            'RISK_REPPROGRAMSUB_NAME' => '5.3.ไม่เพียงพอ',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '5',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '18',
            'RISK_REPPROGRAMSUB_NAME' => '5.4.สูญหาย',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '5',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '19',
            'RISK_REPPROGRAMSUB_NAME' => '5.5.ไม่ได้สอบเทียบ',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '5',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '20',
            'RISK_REPPROGRAMSUB_NAME' => '5.6.เครื่องมืออุปกรณ์การแพทย์ติดไปกับผ้าที่ส่งซัก',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '5',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '21',
            'RISK_REPPROGRAMSUB_NAME' => '4.5.อัคคีภัย',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '4',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '22',
            'RISK_REPPROGRAMSUB_NAME' => '1.8.ภาวะแทรกซ้อนทางทันตกรรม',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '23',
            'RISK_REPPROGRAMSUB_NAME' => '1.9.ภาวะแทรกซ้อนอื่นๆ',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '24',
            'RISK_REPPROGRAMSUB_NAME' => '2.3.Dispensing',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '2',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '25',
            'RISK_REPPROGRAMSUB_NAME' => '2.4.Administration',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '2',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '26',
            'RISK_REPPROGRAMSUB_NAME' => '2.5.Pre-Dispensing',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '2',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '27',
            'RISK_REPPROGRAMSUB_NAME' => '3.2.การทำให้ปราศจากเชื้อไม่มีประสิทธิภาพ  non clinic',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '3',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '28',
            'RISK_REPPROGRAMSUB_NAME' => '3.3.อุบัติเหตุที่เสี่ยงต่อการติดเชื้อ',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '3',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '29',
            'RISK_REPPROGRAMSUB_NAME' => '3.4.ปฏิบัติไม่ถูกต้องตามหลัก IC nonclinic',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '3',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '30',
            'RISK_REPPROGRAMSUB_NAME' => '3.5.การระบาดของเชื้อแบคทีเรียดื้อยา nonclinic',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '3',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '31',
            'RISK_REPPROGRAMSUB_NAME' => '6.1.ตามเจ้าหน้าที่เวรไม่ได้ ล่าช้า',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '6',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '32',
            'RISK_REPPROGRAMSUB_NAME' => '6.2.ปฏิบัติงานไม่ถูกต้องตามคำสั่ง ล่าช้า',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '6',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '33',
            'RISK_REPPROGRAMSUB_NAME' => '6.3.ปัญหาในการสื่อสารระหว่างเจ้าหน้าที่',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '6',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '34',
            'RISK_REPPROGRAMSUB_NAME' => '6.4.ให้ข้อมูลแก่ผู้รับบริการไม่ถูกต้อง ขัดแย้งกัน',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '6',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '35',
            'RISK_REPPROGRAMSUB_NAME' => '6.5.อื่นๆ',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '6',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '36',
            'RISK_REPPROGRAMSUB_NAME' => '7.1.เวชระเบียน',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '7',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '37',
            'RISK_REPPROGRAMSUB_NAME' => '7.2.รายงานผลทางห้องปฏิบัติการ',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '7',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '38',
            'RISK_REPPROGRAMSUB_NAME' => '7.3.การบันทึกข้อมูลการรักษา ไม่สมบูรณ์ ไม่ถูกต้อง',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '7',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '39',
            'RISK_REPPROGRAMSUB_NAME' => '7.4.การ Scan เอกสาร ไม่สมบูรณ์ ไม่ถูกต้อง',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '7',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '40',
            'RISK_REPPROGRAMSUB_NAME' => '7.5.ระบบโปรแกรมขัดข้อง',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '7',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '41',
            'RISK_REPPROGRAMSUB_NAME' => '7.6.ระบบสำรองข้อมูล ขัดข้อง',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '7',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '42',
            'RISK_REPPROGRAMSUB_NAME' => '7.7.คอมพิวเตอร์และอุปกรณ์ขัดข้อง',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '7',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '43',
            'RISK_REPPROGRAMSUB_NAME' => '7.8.อื่นๆ',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '7',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '44',
            'RISK_REPPROGRAMSUB_NAME' => '8.1.ข้อร้องเรียน/ไม่พึงพอใจ',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '8',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '45',
            'RISK_REPPROGRAMSUB_NAME' => '8.2.การละเมิดสิทธิผู้ป่วย',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '8',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '46',
            'RISK_REPPROGRAMSUB_NAME' => '8.3.ไม่สามารถให้บริการตามที่ตกลง',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '8',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '47',
            'RISK_REPPROGRAMSUB_NAME' => '8.4.ปัญหาในการสื่อสารกับผู้รับบริการ',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '8',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '48',
            'RISK_REPPROGRAMSUB_NAME' => '8.5.หนีกลับ ไม่สมัครใจรักษา',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '8',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '49',
            'RISK_REPPROGRAMSUB_NAME' => '9.1.บันทึกสิทธิการรักษาผิดพลาด',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '9',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '50',
            'RISK_REPPROGRAMSUB_NAME' => '9.2.ออกใบเสร็จรับเงินผิดพลาด',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '9',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '51',
            'RISK_REPPROGRAMSUB_NAME' => '9.3.ผู้รับบริการไม่ได้ชำระเงิน ชำระไม่ครบ',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '9',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '52',
            'RISK_REPPROGRAMSUB_NAME' => '9.4.บันทึกค่ารักษาไม่ครบถ้วน ผิดพลาด',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '9',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '53',
            'RISK_REPPROGRAMSUB_NAME' => '9.5.ไม่มียา เวชภัณฑ์ วัสดุการแพทย์ให้ผู้ป่วย',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '9',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '54',
            'RISK_REPPROGRAMSUB_NAME' => '1.10.เสียชีวิต/ส่งต่อ/CPRโดยไม่คาด',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '55',
            'RISK_REPPROGRAMSUB_NAME' => '1.11.การรายงานภาวะวิกฤต ฉุกเฉิน ล่าช้า',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '56',
            'RISK_REPPROGRAMSUB_NAME' => '1.12.ทรุดลงระหว่างส่งต่อโดยไม่คาด',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '57',
            'RISK_REPPROGRAMSUB_NAME' => '1.13.การเก็บสิ่งส่งตรวจไม่ถูกต้อง ไม่ครบถ้วน',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '58',
            'RISK_REPPROGRAMSUB_NAME' => '1.14.อื่นๆ',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '59',
            'RISK_REPPROGRAMSUB_NAME' => '4.6.โจรกรรม/ลักขโมย',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '4',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '60',
            'RISK_REPPROGRAMSUB_NAME' => '4.7.ระบบขนส่ง',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '4',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '61',
            'RISK_REPPROGRAMSUB_NAME' => '4.8.โครงสร้าง อาคาร สถานที่',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '4',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '62',
            'RISK_REPPROGRAMSUB_NAME' => '4.9.ระบบสาธารณูปโภค',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '4',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '63',
            'RISK_REPPROGRAMSUB_NAME' => '4.10.อื่นๆ',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '4',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '64',
            'RISK_REPPROGRAMSUB_NAME' => '8.6 เจ้าหน้าที่ถูกคุกคาม จากผู้รับบริการ',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '8',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_program_sub')->insert(array(
            'RISK_REPPROGRAMSUB_ID' => '65',
            'RISK_REPPROGRAMSUB_NAME' => '9.6 อื่นๆ',
            'RISK_REPPROGRAMSUB_DETAIL' => '',
            'RISK_REPPROGRAM_ID' => '9',
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
