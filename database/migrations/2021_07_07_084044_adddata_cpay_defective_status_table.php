<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdddataCpayDefectiveStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(schema::hasTable('cpay_defective_status')){
            DB::table('cpay_defective_status')->truncate();
            DB::table('cpay_defective_status')->insert([
                [
                'DEFECTIVE_STATUS_ID' => 1,
                'DEFECTIVE_STATUS_NAME' => 'หมดอายุ',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],[
                'DEFECTIVE_STATUS_ID' => 2,
                'DEFECTIVE_STATUS_NAME' => 'ชำรุด',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],[
                'DEFECTIVE_STATUS_ID' => 3,
                'DEFECTIVE_STATUS_NAME' => 'อื่นๆ',
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
        //
    }
}
