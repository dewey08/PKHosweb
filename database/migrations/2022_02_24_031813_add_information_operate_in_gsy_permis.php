<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInformationOperateInGsyPermis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $check = DB::table('gsy_permis')->where('PERMIS_ID','=','OPA001')->count();
        if($check == 0){
    
            DB::table('gsy_permis')->insert(array(
                'PERMIS_ID' => 'OPA001',
                'PERMIS_NAME' => 'ตารางเวรปฏิบัติงาน::ตรวจสอบข้อมูลการจัดสรรเวร',
            ));
    
        }

        $check1 = DB::table('gsy_permis')->where('PERMIS_ID','=','OPA002')->count();
        if($check1 == 0){
    
            DB::table('gsy_permis')->insert(array(
                'PERMIS_ID' => 'OPA002',
                'PERMIS_NAME' => 'ตารางเวรปฏิบัติงาน::อนุมัติข้อมูลการจัดสรรเวร',
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
        Schema::table('gsy_permis', function (Blueprint $table) {
            //
        });
    }
}
