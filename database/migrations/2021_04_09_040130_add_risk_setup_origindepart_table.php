<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRiskSetupOrigindepartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {      
                 
        {    
            DB::table('risk_setup_origindepart')->truncate();
      
            DB::table('risk_setup_origindepart')->insert(array(
                'ORIGIN_DEPART_ID' => '1',
                'ORIGIN_DEPART_CODE' => 'LT001',
                'ORIGIN_DEPART_NAME' => 'OPD',
                'LEVEL_ROOM_ID' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
             ));
            DB::table('risk_setup_origindepart')->insert(array(
                'ORIGIN_DEPART_ID' => '2',
                'ORIGIN_DEPART_CODE' => 'LT002',
                'ORIGIN_DEPART_NAME' => 'IPD',
                'LEVEL_ROOM_ID' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
             ));
            DB::table('risk_setup_origindepart')->insert(array(
                'ORIGIN_DEPART_ID' => '3',
                'ORIGIN_DEPART_CODE' => 'LT003',
                'ORIGIN_DEPART_NAME' => 'อุบัติเหตุ-ฉุกเฉิน',
                'LEVEL_ROOM_ID' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
             ));
            DB::table('risk_setup_origindepart')->insert(array(
                'ORIGIN_DEPART_ID' => '4',
                'ORIGIN_DEPART_CODE' => 'LT004',
                'ORIGIN_DEPART_NAME' => 'หออภิบาลผู้ป่วยหนัก-ไอซียู',
                'LEVEL_ROOM_ID' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
             ));
            DB::table('risk_setup_origindepart')->insert(array(
                'ORIGIN_DEPART_ID' => '5',
                'ORIGIN_DEPART_CODE' => 'LT005',
                'ORIGIN_DEPART_NAME' => 'ห้องคลอด',
                'LEVEL_ROOM_ID' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
             ));
            DB::table('risk_setup_origindepart')->insert(array(
                'ORIGIN_DEPART_ID' => '6',
                'ORIGIN_DEPART_CODE' => 'LT006',
                'ORIGIN_DEPART_NAME' => 'ห้องผ่าตัด',
                'LEVEL_ROOM_ID' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
             ));
            DB::table('risk_setup_origindepart')->insert(array(
                'ORIGIN_DEPART_ID' => '7',
                'ORIGIN_DEPART_CODE' => 'LT007',
                'ORIGIN_DEPART_NAME' => 'งานสนับสนุนทางการแพทย์ (เช่น Lab., X-ray เป็นต้น)',
                'LEVEL_ROOM_ID' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
             ));
            DB::table('risk_setup_origindepart')->insert(array(
                'ORIGIN_DEPART_ID' => '8',
                'ORIGIN_DEPART_CODE' => 'LT008',
                'ORIGIN_DEPART_NAME' => 'งานสนับสนุนทั่วไป : Back office',
                'LEVEL_ROOM_ID' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
             ));
            DB::table('risk_setup_origindepart')->insert(array(
                'ORIGIN_DEPART_ID' => '9',
                'ORIGIN_DEPART_CODE' => 'LT009',
                'ORIGIN_DEPART_NAME' => 'ไม่ใช่พื้นที่ในเขตโรงพยาบาล',
                'LEVEL_ROOM_ID' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
             ));
            DB::table('risk_setup_origindepart')->insert(array(
                'ORIGIN_DEPART_ID' => '10',
                'ORIGIN_DEPART_CODE' => 'LT0010',
                'ORIGIN_DEPART_NAME' => 'ในเขต รพ.อื่น',
                'LEVEL_ROOM_ID' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                ));
            DB::table('risk_setup_origindepart')->insert(array(
                'ORIGIN_DEPART_ID' => '11',
                'ORIGIN_DEPART_CODE' => 'LT0011',
                'ORIGIN_DEPART_NAME' => 'อื่น ฯ',
                'LEVEL_ROOM_ID' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
           
            ));
         
        }
   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        {
            // DB::table('risk_setup_origindepart')->where('ORIGIN_DEPART_CODE','=','LT001')->where('ORIGIN_DEPART_NAME','=','OPD')->where('LEVEL_ROOM_ID','=','')->delete();
            // DB::table('risk_setup_origindepart')->where('ORIGIN_DEPART_CODE','=','LT002')->where('ORIGIN_DEPART_NAME','=','IPD')->where('LEVEL_ROOM_ID','=','')->delete();
            // DB::table('risk_setup_origindepart')->where('ORIGIN_DEPART_CODE','=','LT003')->where('ORIGIN_DEPART_NAME','=','อุบัติเหตุ-ฉุกเฉิน')->where('LEVEL_ROOM_ID','=','')->delete();
            // DB::table('risk_setup_origindepart')->where('ORIGIN_DEPART_CODE','=','LT004')->where('ORIGIN_DEPART_NAME','=','หออภิบาลผู้ป่วยหนัก-ไอซียู')->where('LEVEL_ROOM_ID','=','')->delete();
            // DB::table('risk_setup_origindepart')->where('ORIGIN_DEPART_CODE','=','LT005')->where('ORIGIN_DEPART_NAME','=','ห้องคลอด')->where('LEVEL_ROOM_ID','=','')->delete();
            // DB::table('risk_setup_origindepart')->where('ORIGIN_DEPART_CODE','=','LT006')->where('ORIGIN_DEPART_NAME','=','ห้องผ่าตัด')->where('LEVEL_ROOM_ID','=','')->delete();
            // DB::table('risk_setup_origindepart')->where('ORIGIN_DEPART_CODE','=','LT007')->where('ORIGIN_DEPART_NAME','=','งานสนับสนุนทางการแพทย์ (เช่น Lab., X-ray เป็นต้น)')->where('LEVEL_ROOM_ID','=','')->delete();
            // DB::table('risk_setup_origindepart')->where('ORIGIN_DEPART_CODE','=','LT008')->where('ORIGIN_DEPART_NAME','=','งานสนับสนุนทั่วไป : Back office')->where('LEVEL_ROOM_ID','=','')->delete();
            // DB::table('risk_setup_origindepart')->where('ORIGIN_DEPART_CODE','=','LT009')->where('ORIGIN_DEPART_NAME','=','ไม่ใช่พื้นที่ในเขตโรงพยาบาล')->where('LEVEL_ROOM_ID','=','')->delete();
            // DB::table('risk_setup_origindepart')->where('ORIGIN_DEPART_CODE','=','LT0010')->where('ORIGIN_DEPART_NAME','=','ในเขต รพ.อื่น')->where('LEVEL_ROOM_ID','=','')->delete();
            // DB::table('risk_setup_origindepart')->where('ORIGIN_DEPART_CODE','=','LT0011')->where('ORIGIN_DEPART_NAME','=','อื่น ฯ')->where('LEVEL_ROOM_ID','=','')->delete();
        }
    }
}
