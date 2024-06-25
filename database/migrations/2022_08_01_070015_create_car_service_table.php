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
        if (!Schema::hasTable('car_service'))
        {
        Schema::create('car_service', function (Blueprint $table) {
            $table->bigIncrements('car_service_id'); 
            $table->string('car_service_no')->nullable();// 
                $table->string('car_service_book')->nullable();// ตามหนังสือเลขที่ 
                $table->string('car_service_year')->nullable();// ปีงบประมาณ 
                $table->string('car_service_speed')->nullable();// ความเร่งด่วน
                $table->string('car_service_article_id',255)->nullable();//รถ
                $table->string('car_service_register',255)->nullable();//ทะเบียนรถ        
                $table->string('car_service_rate')->nullable();//ประเมินความพึงพอใจ
                $table->string('car_service_mikenumber_befor')->nullable();//  เลขไมค์ก่อนเดินทาง   
                $table->string('car_service_mikenumber_after')->nullable();//  เลขไมค์หลังเดินทาง 
                $table->date('car_service_date')->nullable();//วันที่ไป count
                $table->date('car_service_length_godate')->nullable();//วันที่ไป               
                $table->Time('car_service_length_gotime')->nullable();// เวลาไป 
                $table->date('car_service_length_backdate')->nullable();//วันที่กลับ              
                $table->Time('car_service_length_backtime')->nullable();// เวลากลับ 
                $table->string('car_service_length')->nullable();//ระยะทาง  
                $table->string('car_service_location',255)->nullable();//สถานที่ไป
                $table->string('car_service_location_name',255)->nullable();//สถานที่ไป
                $table->string('car_service_reason',255)->nullable();//เหตุผล 
                $table->Time('car_service_drive_gotime')->nullable();// เวลาไป พนักงานขับ 
                $table->Time('car_service_drive_backtime')->nullable();// เวลากลับ พนักงานขับ
                $table->string('car_service_userdrive_id',255)->nullable();//พนักงานขับ 
                $table->string('car_service_userdrive_name',255)->nullable();//พนักงานขับ 
                $table->string('car_service_user_id',255)->nullable();//ผู้ร้องขอ 
                $table->string('car_service_user_name',255)->nullable();//ผู้ร้องขอ 
                $table->string('car_service_staff_id',255)->nullable();//ผู้จัดสรร
                $table->string('car_service_staff_name',255)->nullable();//ผู้จัดสรร
                $table->string('car_service_manage_id',255)->nullable();//ผู้
                $table->string('car_service_manage_name',255)->nullable();//ผู้
                $table->string('car_service_po_id',255)->nullable();//ผู้อำนวยการ
                $table->string('car_service_po_name',255)->nullable();//ผู้อำนวยการ
                $table->string('car_service_status', 255)->nullable();
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
        Schema::dropIfExists('car_service');
    }
};
