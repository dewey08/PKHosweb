<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdddataGleaveStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('gleave_status')) {
            DB::table('gleave_status')->truncate();

            Schema::table('gleave_status', function (Blueprint $table){
                if(!schema::hasColumn('gleave_status','STATUS_RANK')){
                    $table->string("STATUS_RANK",255)->nullable();
                }
            });
          

        }



        DB::table('gleave_status')->insert(array(
            'STATUS_RANK' => '01',
            'STATUS_CODE' => 'Allow',
            'STATUS_NAME' => 'ผอ.อนุมัติ',
        ));
        DB::table('gleave_status')->insert(array(
            'STATUS_RANK' => '02',
            'STATUS_CODE' => 'Disallow',
            'STATUS_NAME' => 'ไม่อนุมัติ',
        ));
        DB::table('gleave_status')->insert(array(
            'STATUS_RANK' => '03',
            'STATUS_CODE' => 'Approve',
            'STATUS_NAME' => 'เห็นชอบ',
        ));
        DB::table('gleave_status')->insert(array(
            'STATUS_RANK' => '04',
            'STATUS_CODE' => 'Pending',
            'STATUS_NAME' => 'รอเห็นชอบ',
        ));
        DB::table('gleave_status')->insert(array(
            'STATUS_RANK' => '05',
            'STATUS_CODE' => 'Disapprove',
            'STATUS_NAME' => 'ไม่เห็นชอบ',
        ));
        DB::table('gleave_status')->insert(array(
            'STATUS_RANK' => '06',
            'STATUS_CODE' => 'Verify',
            'STATUS_NAME' => 'ตรวจสอบผ่าน',
        ));
        DB::table('gleave_status')->insert(array(
            'STATUS_RANK' => '07',
            'STATUS_CODE' => 'Disverify',
            'STATUS_NAME' => 'ตรวจสอบไม่ผ่าน',
        ));
        DB::table('gleave_status')->insert(array(
            'STATUS_RANK' => '08',
            'STATUS_CODE' => 'Recancel',
            'STATUS_NAME' => 'แจ้งยกเลิก',
        ));
        DB::table('gleave_status')->insert(array(
            'STATUS_RANK' => '09',
            'STATUS_CODE' => 'Appcancel',
            'STATUS_NAME' => 'เห็นชอบยกเลิก',
        ));
        DB::table('gleave_status')->insert(array(
            'STATUS_RANK' => '10',
            'STATUS_CODE' => 'Disappcancel',
            'STATUS_NAME' => 'ไม่เห็นชอบยกเลิก',
        ));
        DB::table('gleave_status')->insert(array(
            'STATUS_RANK' => '11',
            'STATUS_CODE' => 'Cancel',
            'STATUS_NAME' => 'ยกเลิก',
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
