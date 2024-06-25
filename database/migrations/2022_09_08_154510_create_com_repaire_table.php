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
        if (!Schema::hasTable('com_repaire'))
        {
        Schema::create('com_repaire', function (Blueprint $table) {
                $table->bigIncrements('com_repaire_id'); 
                $table->string('com_repaire_no')->nullable();// รหัสแจ้งซ่อม 
                $table->string('com_repaire_year')->nullable();// ปีงบประมาณ 
                $table->string('com_repaire_speed')->nullable();// ความเร่งด่วน                    
                $table->string('com_repaire_rate')->nullable();//ประเมินความพึงพอใจ 
                $table->date('com_repaire_date')->nullable();//วันที่แจ้งซ่อม               
                $table->Time('com_repaire_time')->nullable();// เวลา 
                $table->date('com_repaire_work_date')->nullable();//วันที่ซ่อม               
                $table->Time('com_repaire_work_time')->nullable();// เวลาซ่อม
                $table->date('com_repaire_send_date')->nullable();//วันที่ส่งงาน              
                $table->Time('com_repaire_send_time')->nullable();// เวลาที่ส่งงาน  
                $table->string('com_repaire_detail')->nullable();//รายละเอียด/อาการ   
                $table->string('com_repaire_tec_id',255)->nullable();//ระบุช่าง
                $table->string('com_repaire_tec_name',255)->nullable();//ระบุช่าง 
                $table->string('com_repaire_detail_tech',255)->nullable();//รายละเอียด/อาการ  ช่าง
                $table->string('com_repaire_article_id',255)->nullable();//รายการที่ซ่อม
                $table->string('com_repaire_article_num',255)->nullable();//รายการที่ซ่อม
                $table->string('com_repaire_article_name',255)->nullable();//รายการที่ซ่อม    
                $table->string('com_repaire_user_id',255)->nullable();//ผู้แจ้ง
                $table->string('com_repaire_user_name',255)->nullable();//ผู้แจ้ง 
                $table->string('com_repaire_debsubsub_id',255)->nullable();//หน่วยงาน
                $table->string('com_repaire_debsubsub_name',255)->nullable();//หน่วยงาน 
                $table->string('com_repaire_rep_id',255)->nullable();//ผู้รับงาน
                $table->string('com_repaire_rep_name',255)->nullable();//ผู้รับงาน 
                $table->string('com_repaire_status', 255)->nullable();
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
        Schema::dropIfExists('com_repaire');
    }
};
