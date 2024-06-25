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
        if (!Schema::hasTable('meeting_service'))
        {
            Schema::create('meeting_service', function (Blueprint $table) {
                $table->bigIncrements('meeting_id');
                $table->string('room_id')->nullable();//ห้องประชุม
                $table->string('room_name')->nullable();//ห้องประชุม
                $table->string('meetting_title')->nullable();//เรื่องการประชุม
                $table->string('meetting_year')->nullable();//ปีงบประมาณ    
                $table->string('meetting_target')->nullable();// กลุ่มบุคคลเป้าหมาย
                $table->string('meetting_person_qty')->nullable();//จำนวน
                $table->string('meeting_objective_id')->nullable();//วัตถุประสงค์การขอใช้
                $table->string('meeting_objective_name')->nullable();//วัตถุประสงค์การขอใช้
                $table->string('meeting_tel')->nullable();//เบอร์โทร
                $table->date('meeting_date_begin')->nullable();//ตั้งแต่วันที่
                $table->time('meeting_time_begin')->nullable();//ตั้งแต่เวลา
                $table->time('meeting_time_end')->nullable();//ถึงเวลา 
                $table->date('meeting_date_end')->nullable();//ถึงวันที่
                $table->time('meeting_time2_begin')->nullable();//ตั้งแต่เวลา
                $table->time('meeting_time2_end')->nullable();//ถึงเวลา 
                $table->dateTime('meeting_date_save')->nullable();//วันที่บันทึก              
                $table->string('meetting_status')->nullable();//สถานะ
                $table->string('meeting_debsubsubtrue_id')->nullable();//หน่วยงาน
                $table->string('meeting_debsubsubtrue_name')->nullable();//หน่วยงาน
                $table->string('meeting_user_id')->nullable();//คนร้องขอ
                $table->string('meeting_user_name')->nullable();//คนร้องขอ
                $table->string('meeting_usercheck_id')->nullable();//คนตรวจสอบ
                $table->string('meeting_usercheck_name')->nullable();//คนตรวจสอบ
                $table->string('meeting_po_id')->nullable();//ผู้อนุมัติ
                $table->string('meeting_po_name')->nullable();//ผู้อนุมัติ 
                $table->string('meeting_comment')->nullable();//meeting_comment 
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meeting_service');
    }
};
