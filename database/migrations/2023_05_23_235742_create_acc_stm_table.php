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
        if (!Schema::hasTable('acc_stm'))
        {
            Schema::connection('mysql')->create('acc_stm', function (Blueprint $table) {
                $table->bigIncrements('acc_stm_id');                  
                $table->string('hn')->nullable();//   
                $table->string('vn')->nullable();//  
                $table->string('an')->nullable();//  
                $table->string('cid')->nullable();//
                $table->string('fullname')->nullable();//ชื่อ-สกุล             
                $table->date('vstdate')->nullable();//วันที่เข้ารับบริการ
                $table->date('regtdate')->nullable();//วันที่ลงทะเบียน   
                $table->double('debit', 12, 4)->nullable();//เงินลูกหนี้
                $table->double('price_approve', 12, 4)->nullable();//จ่ายชดเชยสุทธิ
                $table->double('price_sauntang', 12, 4)->nullable();//ส่วนต่าง

                $table->double('price_req', 12, 4)->nullable();//จำนวนเงินที่ขอเบิก                
                $table->double('price_approve_no', 12, 4)->nullable();//ไม่ชดเชย

                $table->string('repno',100)->nullable();//  rep              
                $table->string('tranid')->nullable();//  เลขที่หนังสือ
                $table->date('date_rep')->nullable();// วันที่รับ

                $table->string('subinscl')->nullable();//สิทธิ์การรักษาพยาบาล
                $table->string('comment')->nullable();//หมายเหตุ
                $table->date('date_save')->nullable();//
                $table->string('type_req')->nullable();//รายการ/ประเภทที่ขอเบิก
               
               
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
        Schema::dropIfExists('acc_stm');
    }
};
