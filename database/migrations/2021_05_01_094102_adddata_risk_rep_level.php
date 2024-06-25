<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdddataRiskRepLevel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('risk_rep_level')) {
            DB::table('risk_rep_level')->truncate();
        }
        DB::table('risk_rep_level')->insert(array(
            'RISK_REP_LEVEL_ID' => '1',
            'RISK_REP_LEVEL_CODE' => '00001',
            'RISK_REP_LEVEL_NAME' => 'A',
            'RISK_REP_LEVEL_DETAIL' => '(เกิดที่นี่) เกิดเหตุการขึ้นแล้วจากตัวเองและค้นพบได้ด้วยตัวเองสามารถปรับแก้ไขได้ไม่ส่งผลกระทบถึงผู้อื่นและผู้ป่วยหรือบุคลากร',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_level')->insert(array(
            'RISK_REP_LEVEL_ID' => '2',
            'RISK_REP_LEVEL_CODE' => '00002',
            'RISK_REP_LEVEL_NAME' => 'B',
            'RISK_REP_LEVEL_DETAIL' => '(เกิดที่ไกล) เกิดเหตุการณ์/ความผิดพลาดขึ้นแล้วโดยส่งต่อเหตุการณ์/ความผิดพลาดนั้นไปที่ผู้อื่น แต่สามารถตรวจพบและแก้ไขได้ โดยยังไม่มีผลกระทบไดฯถึงผู้ป่วยหรือบุคลากร',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_level')->insert(array(
            'RISK_REP_LEVEL_ID' => '3',
            'RISK_REP_LEVEL_CODE' => '00003',
            'RISK_REP_LEVEL_NAME' => 'C',
            'RISK_REP_LEVEL_DETAIL' => '(เกิดกับใคร) เกิดเหตุการณ์/ความผิดพลาดขึ้นและมีผลกระทบถึงผู้ป่วยหรือบุคลากร แต่ไม่เกิดอันตรายหรือเสียหาย',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_level')->insert(array(
            'RISK_REP_LEVEL_ID' => '4',
            'RISK_REP_LEVEL_CODE' => '00004',
            'RISK_REP_LEVEL_NAME' => 'D',
            'RISK_REP_LEVEL_DETAIL' => '(ให้ระวัง) เกิดผิดพลาดขึ้น มีผลกระทบถึงผู้ป่วยหรือบุคลากร ต้องไห้การดูแลเฝ้าระวังเป็นพิเศษว่าจะไม่เป็นอันตราย',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_level')->insert(array(
            'RISK_REP_LEVEL_ID' => '5',
            'RISK_REP_LEVEL_CODE' => '00005',
            'RISK_REP_LEVEL_NAME' => 'E',
            'RISK_REP_LEVEL_DETAIL' => '(ต้องรักษา) เกิดความผิดพลาดขึ้น มีผลกระทบถึงผู้ป่วยหรือบุคลากร เกิดอันตรายชั่วคราวที่ต้องแก้ไข/รักษาเพิ่มมากขึ้น',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_level')->insert(array(
            'RISK_REP_LEVEL_ID' => '6',
            'RISK_REP_LEVEL_CODE' => '00006',
            'RISK_REP_LEVEL_NAME' => 'F',
            'RISK_REP_LEVEL_DETAIL' => '(เยียวยานาน) เกิดความผิดพลาดขึ้น มีผลกระทบที่ต้องใช้เวลาการแก้ไขนานกว่าปกติหรือเกินกำหนด ผู้ป่วยหรือบุคลากรต้องรักษา/นอนโรงพยาบาลนานขึ้น',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_level')->insert(array(
            'RISK_REP_LEVEL_ID' => '7',
            'RISK_REP_LEVEL_CODE' => '00007',
            'RISK_REP_LEVEL_NAME' => 'G',
            'RISK_REP_LEVEL_DETAIL' => '(ต่องพิการ) เกิดความผิดพลาดถึงผู้ป่วยหรือบุคลากร ทำไห้เกิดความพิการถาวรหรือมีผลกระทบทำไห้เสียชื่อเสียง/ความเชื่อถือและ/หรือมีการร้องเรียน',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_level')->insert(array(
            'RISK_REP_LEVEL_ID' => '8',
            'RISK_REP_LEVEL_CODE' => '00008',
            'RISK_REP_LEVEL_NAME' => 'H',
            'RISK_REP_LEVEL_DETAIL' => '(ต้องการปั๊ม) เกิดความผิดพลาด ถึงผู้ป่วยหรือบุคลากร มีผลทำไห้ต้องทำการช่วยชีวิต หรือในกรณีที่ทำไห้เสียชื่อเสียงและ/หรือมีการเรียกร้องค่าเสียหายจากโรงพยาบาล',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_level')->insert(array(
            'RISK_REP_LEVEL_ID' => '9',
            'RISK_REP_LEVEL_CODE' => '00009',
            'RISK_REP_LEVEL_NAME' => 'I',
            'RISK_REP_LEVEL_DETAIL' => '(จำใจลา) เกิดความผิดพลาดถึงผู้ป่วยหรือบุคลากร เป็นสาเหตุทำไห้เสียชีวิต เสียชื่อเสียงโดยมีการฟ้องร้องทางศาล/สื่อ',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_level')->insert(array(
            'RISK_REP_LEVEL_ID' => '10',
            'RISK_REP_LEVEL_CODE' => '00010',
            'RISK_REP_LEVEL_NAME' => '1',
            'RISK_REP_LEVEL_DETAIL' => 'เกิดความผิดพลาดขึ้นแต่ไม่มีผลกระทบต่อผลสำเร็จหรือวัตถุประสงค์ของการดำเนินงาน(* เกิดผลกระทบที่มีมูลค่าความเสียหาย 0-10,000 บาท)',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_level')->insert(array(
            'RISK_REP_LEVEL_ID' => '11',
            'RISK_REP_LEVEL_CODE' => '00011',
            'RISK_REP_LEVEL_NAME' => '2',
            'RISK_REP_LEVEL_DETAIL' => 'เกิดความผิดพลาดขึ้นแล้วโดยมีผลกระทบ (ที่ควบคุมได้) ต่อผลสำเร็จหรือวัตถุประสงค์ของการดำเนินงาน(* เกิดผลกระทบที่มีมูลค่าความเสียหาย 10,001-50,000 บาท)',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_level')->insert(array(
            'RISK_REP_LEVEL_ID' => '12',
            'RISK_REP_LEVEL_CODE' => '00012',
            'RISK_REP_LEVEL_NAME' => '3',
            'RISK_REP_LEVEL_DETAIL' => 'เกิดความผิดพลาดขึ้นแล้วและมีผลกระทบ (ที่ต้องทำการแก้ไข) ต่อผลสำเร็จหรือวัตถุประสงค์ของการดำเนินงาน(* เกิดผลกระทบที่มีมูลค่าความเสียหาย 50,001-250,000 บาท)',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_level')->insert(array(
            'RISK_REP_LEVEL_ID' => '13',
            'RISK_REP_LEVEL_CODE' => '00013',
            'RISK_REP_LEVEL_NAME' => '4',
            'RISK_REP_LEVEL_DETAIL' => 'เกิดความผิดพลาดขึ้นแล้ว และทำไห้การดำเนินงาน ไม่บรรลุผลสำเร็จตามเป้าหมาย(* เกิดผลกระทบที่มีมูลค่าความเสียหาย 250,001-10,000,000 บาท)',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_level')->insert(array(
            'RISK_REP_LEVEL_ID' => '14',
            'RISK_REP_LEVEL_CODE' => '00014',
            'RISK_REP_LEVEL_NAME' => '5',
            'RISK_REP_LEVEL_DETAIL' => 'เกิดความผิดพลาดขึ้นแล้ว และมีผลทำไห้การดำเนินงาน ไม่บรรลุผลสำเร็จตามเป้าหมาย ทำไห้ภารกิจขององค์กรเสียหายอย่างร้ายแรง(* เกิดผลกระทบที่มีมูลค่าความเสียหาย มากกว่า 10 ล้านบาท)',
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
