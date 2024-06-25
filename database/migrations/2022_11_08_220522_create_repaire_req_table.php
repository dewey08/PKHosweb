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
        if (!Schema::hasTable('repaire_req'))
        {
        Schema::create('repaire_req', function (Blueprint $table) {
                $table->bigIncrements('repaire_req_id'); 
                $table->string('repaire_req_no')->nullable();// รหัสแจ้งซ่อม 
                $table->string('repaire_req_year')->nullable();// ปีงบประมาณ 
                $table->string('repaire_req_speed')->nullable();// ความเร่งด่วน                    
                $table->string('repaire_req_rate')->nullable();//ประเมินความพึงพอใจ 
                $table->date('repaire_req_date')->nullable();//วันที่แจ้งซ่อม               
                $table->Time('repaire_req_time')->nullable();// เวลา 
                $table->date('repaire_req_work_date')->nullable();//วันที่ซ่อม               
                $table->Time('repaire_req_work_time')->nullable();// เวลาซ่อม
                $table->date('repaire_req_send_date')->nullable();//วันที่ส่งงาน              
                $table->Time('repaire_req_send_time')->nullable();// เวลาที่ส่งงาน  
                $table->string('repaire_req_detail')->nullable();//รายละเอียด/อาการ   
                $table->string('repaire_req_tec_id',255)->nullable();//ระบุช่าง
                $table->string('repaire_req_tec_name',255)->nullable();//ระบุช่าง 
                $table->string('repaire_req_detail_tech',255)->nullable();//รายละเอียด/อาการ  ช่าง
                $table->string('repaire_req_article_id',255)->nullable();//รายการที่ซ่อม
                $table->string('repaire_req_article_num',255)->nullable();//รายการที่ซ่อม
                $table->string('repaire_req_article_name',255)->nullable();//รายการที่ซ่อม    
                $table->string('repaire_req_user_id',255)->nullable();//ผู้แจ้ง
                $table->string('repaire_req_user_name',255)->nullable();//ผู้แจ้ง 
                $table->string('repaire_req_debsubsub_id',255)->nullable();//หน่วยงาน
                $table->string('repaire_req_debsubsub_name',255)->nullable();//หน่วยงาน 
                $table->string('repaire_req_rep_id',255)->nullable();//ผู้รับงาน
                $table->string('repaire_req_rep_name',255)->nullable();//ผู้รับงาน 
                $table->string('repaire_req_status', 255)->nullable();
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
        Schema::dropIfExists('repaire_req');
    }
};
