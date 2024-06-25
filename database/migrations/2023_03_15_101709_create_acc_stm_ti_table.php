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
        if (!Schema::hasTable('acc_stm_ti'))
        {
            Schema::connection('mysql')->create('acc_stm_ti', function (Blueprint $table) {
                $table->bigIncrements('acc_stm_ti_id'); 
                $table->string('repno',100)->nullable();//                
                $table->string('tranid')->nullable();//    
                $table->string('hn')->nullable();//   
                $table->string('cid')->nullable();//
                $table->string('fullname')->nullable();//ชื่อ-สกุล
                $table->string('subinscl')->nullable();//สิทธิ์การรักษาพยาบาล
                $table->date('vstdate')->nullable();//วันที่เข้ารับบริการ
                $table->date('regtdate')->nullable();//วันที่ลงทะเบียน
                $table->string('type_req')->nullable();//รายการ/ประเภทที่ขอเบิก
                $table->double('price_req', 12, 4)->nullable();//จำนวนเงินที่ขอเบิก
                $table->double('price_approve', 12, 4)->nullable();//จ่ายชดเชยสุทธิ
                $table->double('price_approve_no', 12, 4)->nullable();//ไม่ชดเชย
                $table->string('comment')->nullable();//หมายเหตุ
                $table->date('date_save')->nullable();//
                // $table->Time('time_rep')->nullable();// 
                $table->string('vn')->nullable();//  

                $table->string('invno')->nullable();//  
                $table->string('dttran',255)->nullable();//   
                $table->double('hdrate', 12, 4)->nullable();// 
                $table->double('hdcharge', 12, 4)->nullable();// 
                $table->double('amount', 12, 4)->nullable();// 
                $table->double('paid', 12, 4)->nullable();// 
                $table->string('rid')->nullable();//  
                $table->string('accp')->nullable();//  
                $table->string('HDflag')->nullable();//   

                $table->string('AccPeriod')->nullable();//  
                $table->string('STMdoc')->nullable();//  
                $table->string('Total_amount')->nullable();//  
                $table->string('Total_thamount')->nullable();//  
                
                $table->enum('active', ['REP','APPROVE','CANCEL','FINISH'])->default('REP')->nullable(); 
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
        Schema::dropIfExists('acc_stm_ti');
    }
};
