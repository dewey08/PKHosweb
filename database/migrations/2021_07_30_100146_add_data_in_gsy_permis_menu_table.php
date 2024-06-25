<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataInGsyPermisMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      

        if (Schema::hasTable('gsy_permis_menu')) {

            
        DB::table('gsy_permis_menu')->truncate();
        DB::table('gsy_permis_menu')->insert([
        [
            'PERMIS_MENU_ID' => '1',
            'PERMIS_MENU_NAME' => 'ลงเวลาปฏิบัติงาน',
            'ACTIVE' => 'True',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
            'PERMIS_MENU_ID' => 2,
            'PERMIS_MENU_NAME' => 'ข้อมูลการทำงาน',
            'ACTIVE' => 'True',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
            'PERMIS_MENU_ID' => 3,
            'PERMIS_MENU_NAME' => 'ข้อมูลสุขภาพ',
            'ACTIVE' => 'True',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
            'PERMIS_MENU_ID' => 4,
            'PERMIS_MENU_NAME' => 'ข้อมูลการลา',
            'ACTIVE' => 'True',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
            'PERMIS_MENU_ID' => 5,
            'PERMIS_MENU_NAME' => 'ประชุม/อบรม/ดูงาน',
            'ACTIVE' => 'True',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
            'PERMIS_MENU_ID' => 6,
            'PERMIS_MENU_NAME' => 'เงินเดือนค่าตอบแทน',
            'ACTIVE' => 'True',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
            'PERMIS_MENU_ID' => 7,
            'PERMIS_MENU_NAME' => 'สวัสดิการบ้านพัก',
            'ACTIVE' => 'True',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
            'PERMIS_MENU_ID' => 8,
            'PERMIS_MENU_NAME' => 'งานสารบรรณ',
            'ACTIVE' => 'True',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
            'PERMIS_MENU_ID' => 9,
            'PERMIS_MENU_NAME' => 'งานบริการห้องประชุม',
            'ACTIVE' => 'True',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
            'PERMIS_MENU_ID' => 10,
            'PERMIS_MENU_NAME' => 'งานบริการยานพาหนะ',
            'ACTIVE' => 'True',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
            'PERMIS_MENU_ID' => 11,
            'PERMIS_MENU_NAME' => 'งานบริหารทรัพย์สิน',
            'ACTIVE' => 'True',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
            'PERMIS_MENU_ID' => 12,
            'PERMIS_MENU_NAME' => 'งานพัสดุ',
            'ACTIVE' => 'True',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
            'PERMIS_MENU_ID' => 13,
            'PERMIS_MENU_NAME' => 'คลังพัสดุ',
            'ACTIVE' => 'True',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
            'PERMIS_MENU_ID' => 14,
            'PERMIS_MENU_NAME' => 'งานแจ้งซ่อมบำรุง',
            'ACTIVE' => 'True',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
            'PERMIS_MENU_ID' => 15,
            'PERMIS_MENU_NAME' => 'ตารางเวรปฏิบัติงาน',
            'ACTIVE' => 'True',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
            'PERMIS_MENU_ID' => 16,
            'PERMIS_MENU_NAME' => 'งานซักฟอก',
            'ACTIVE' => 'True',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
            'PERMIS_MENU_ID' => 17,
            'PERMIS_MENU_NAME' => 'งานจ่ายกลาง',
            'ACTIVE' => 'True',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
            'PERMIS_MENU_ID' => 18,
            'PERMIS_MENU_NAME' => 'ความเสี่ยง',
            'ACTIVE' => 'True',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
            'PERMIS_MENU_ID' => 19,
            'PERMIS_MENU_NAME' => 'แผนงานโครงการ',
            'ACTIVE' => 'True',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
            'PERMIS_MENU_ID' => 20,
            'PERMIS_MENU_NAME' => 'ตารางจัด OT',
            'ACTIVE' => 'True',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
    
    
    
    
    
    ]);



        }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gsy_permis_menu', function (Blueprint $table) {
            //
        });
    }
}
