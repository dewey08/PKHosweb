<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class AddInfomationInGsyPermis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $check = DB::table('gsy_permis')->where('PERMIS_ID','=','GLE005')->count();
        if($check == 0){
    
            DB::table('gsy_permis')->insert(array(
                'PERMIS_ID' => 'GLE005',
                'PERMIS_NAME' => 'ระบบลา::หัวหน้ากลุ่มงานเห็นชอบ',
         
             
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
