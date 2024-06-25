<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class AddInfomationInGleaveStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $check1 = DB::table('gleave_status')->where('STATUS_CODE','=','ApproveGroup')->count();
        $check2 = DB::table('gleave_status')->where('STATUS_CODE','=','DisapproveGroup')->count();
    if($check1 == 0){

        DB::table('gleave_status')->insert(array(
            'STATUS_CODE' => 'ApproveGroup',
            'STATUS_NAME' => 'หน.กลุ่มเห็นชอบ',
            'STATUS_RANK' => '13',
           
        ));

    }

    if($check2 == 0){
            DB::table('gleave_status')->insert(array(
                'STATUS_CODE' => 'DisapproveGroup',
                'STATUS_NAME' => 'หน.กลุ่มไม่เห็นชอบ',
                'STATUS_RANK' => '14',
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
        Schema::table('gleave_register', function (Blueprint $table) {
            //
        });
    }
}
