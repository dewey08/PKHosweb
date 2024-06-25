<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {       
        if (!Schema::hasTable('meeting_status'))
        {
            Schema::create('meeting_status', function (Blueprint $table) {
                $table->bigIncrements('meeting_status_id'); 
                $table->string('meeting_status_code',255)->nullable();// 
                $table->string('meeting_status_name',255)->nullable();//สถานะ   
                $table->timestamps();
            }); 
            
            if (Schema::hasTable('meeting_status')) {
                DB::table('meeting_status')->truncate();
            }
            DB::table('meeting_status')->insert(array(
                'meeting_status_id' => '1',
                'meeting_status_code' => 'REQUEST',
                'meeting_status_name' => 'ร้องขอ',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('meeting_status')->insert(array(
                'meeting_status_id' => '2',
                'meeting_status_code' => 'ALLOCATE',
                'meeting_status_name' => 'จัดสรร',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('meeting_status')->insert(array(
                'meeting_status_id' => '3',
                'meeting_status_code' => 'ALLOWPO',
                'meeting_status_name' => 'อนุมัติ',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('meeting_status')->insert(array(
                'meeting_status_id' => '4',
                'meeting_status_code' => 'CANCEL',
                'meeting_status_name' => 'แจ้งยกเลิก',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('meeting_status')->insert(array(
                'meeting_status_id' => '5',
                'meeting_status_code' => 'CANCELOK',
                'meeting_status_name' => 'ยืนยันการยกเลิก',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('meeting_status')->insert(array(
                'meeting_status_id' => '6',
                'meeting_status_code' => 'ALL',
                'meeting_status_name' => 'ทั้งหมด',           
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
        Schema::dropIfExists('meeting_status');
    }
};
