<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdddataPermissTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $check =  DB::table('gsy_permis')->where('PERMIS_ID', '=', 'HAPPY01')->count();
        $check2 =  DB::table('gsy_permis')->where('PERMIS_ID', '=', 'HAPPY02')->count();
        $check3 =  DB::table('gsy_permis')->where('PERMIS_ID', '=', 'HAPPY03')->count();

        if ($check == 0) {
            DB::table('gsy_permis')->insert(array(
                'PERMIS_ID' => 'HAPPY01',
                'PERMIS_NAME' => 'ระบบความสุขของบุคลากรจัดการแจกของรางวัล',

            ));
        }
        if ($check2 == 0) {
        DB::table('gsy_permis')->insert(array(
            'PERMIS_ID' => 'HAPPY02',
            'PERMIS_NAME' => 'ระบบความสุขของบุคลากร :: จัดการข้อมูลระบบ',

        ));
         }
         if ($check3 == 0) {
        DB::table('gsy_permis')->insert(array(
            'PERMIS_ID' => 'HAPPY03',
            'PERMIS_NAME' => 'ระบบความสุขของบุคลากร :: กำหนดสิทธิบุคคลให้คะแนนพิเศษ',

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
        //
    }
}
