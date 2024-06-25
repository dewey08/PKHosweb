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
        if (!Schema::hasTable('car_index'))
        {
        Schema::create('car_index', function (Blueprint $table) {
            $table->bigIncrements('car_index_id');  
                $table->string('car_index_speed')->nullable();// ความเร่งด่วน
                $table->string('car_index_article_id',255)->nullable();//รถ
                $table->string('car_index_register',255)->nullable();//ทะเบียนรถ        
                $table->string('car_index_rate')->nullable();//ประเมินความพึงพอใจ
                $table->string('car_index_mikenumber_befor')->nullable();//  เลขไมค์ก่อนเดินทาง   
                $table->string('car_index_mikenumber_after')->nullable();//  เลขไมค์หลังเดินทาง 
                $table->string('car_index_length_godate')->nullable();//วันที่ไป               
                $table->Time('car_index_length_gotime')->nullable();// เวลาไป 
                $table->string('car_index_length_backdate')->nullable();//วันที่กลับ              
                $table->Time('car_index_length_backtime')->nullable();// เวลากลับ 
                $table->string('car_index_length')->nullable();//ระยะทาง  
                $table->string('car_index_location',255)->nullable();//สถานที่ไป
                $table->string('car_index_reason',255)->nullable();//เหตุผล 
                $table->string('car_index__user_id',255)->nullable();//ผู้ร้องขอ 
                $table->string('car_index__user_name',255)->nullable();//ผู้ร้องขอ 
                $table->string('car_index__manage_id',255)->nullable();//ผู้จัดสรร
                $table->string('car_index__manage_name',255)->nullable();//ผู้จัดสรร
                $table->string('car_index__po_id',255)->nullable();//ผู้อำนวยการ
                $table->string('car_index__po_name',255)->nullable();//ผู้อำนวยการ
                $table->string('car_index_status', 255)->nullable();
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
        Schema::dropIfExists('car_index');
    }
};
