<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdddataRiskRepTypereasonSys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('risk_rep_typereason_sys')) {
            DB::table('risk_rep_typereason_sys')->truncate();
        }

        DB::table('risk_rep_typereason_sys')->insert(array(
            'RISK_REPTYPERESONSYS_ID' => '1',
            'RISK_REPTYPERESONSYS_NAME' => 'การฝึกอบรมปฐมนิเทศ',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_typereason_sys')->insert(array(
            'RISK_REPTYPERESONSYS_ID' => '2',
            'RISK_REPTYPERESONSYS_NAME' => 'การเข้าถึงข้อมูลข่าวสาร',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_typereason_sys')->insert(array(
            'RISK_REPTYPERESONSYS_ID' => '3',
            'RISK_REPTYPERESONSYS_NAME' => 'สิ่งแวดล้อม',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_typereason_sys')->insert(array(
            'RISK_REPTYPERESONSYS_ID' => '4',
            'RISK_REPTYPERESONSYS_NAME' => 'วัฒนธรรมองค์กร',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_typereason_sys')->insert(array(
            'RISK_REPTYPERESONSYS_ID' => '5',
            'RISK_REPTYPERESONSYS_NAME' => 'ช่องทางการสื่อสาร',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_typereason_sys')->insert(array(
            'RISK_REPTYPERESONSYS_ID' => '6',
            'RISK_REPTYPERESONSYS_NAME' => 'สมรรถนะของเจ้าหน้าที่',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_typereason_sys')->insert(array(
            'RISK_REPTYPERESONSYS_ID' => '7',
            'RISK_REPTYPERESONSYS_NAME' => 'ภาระงาน',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_typereason_sys')->insert(array(
            'RISK_REPTYPERESONSYS_ID' => '8',
            'RISK_REPTYPERESONSYS_NAME' => 'การออกแบบระบบงาน',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_typereason_sys')->insert(array(
            'RISK_REPTYPERESONSYS_ID' => '9',
            'RISK_REPTYPERESONSYS_NAME' => 'การนิเทศน์ควบคุมกำกับ',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_typereason_sys')->insert(array(
            'RISK_REPTYPERESONSYS_ID' => '10',
            'RISK_REPTYPERESONSYS_NAME' => 'ความบกพร่องของเครื่องมือ',
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
