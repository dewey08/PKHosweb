<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailGsyPermisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gsy_permis', function (Blueprint $table) {
           
            $check = DB::table('gsy_permis')->where('PERMIS_ID','=','GMR002')->count();
  
            if($check == 0){
                DB::table('gsy_permis')->insert(array(
                    'PERMIS_ID' => 'GMR002',
                    'PERMIS_NAME' => 'ตรวจสอบบันทึกความเสี่ยง',
                   
                ));
            }


        });
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
