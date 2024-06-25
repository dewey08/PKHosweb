<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    { 
        if (!Schema::hasTable('a_stm_ct_excel'))
        {
            Schema::create('a_stm_ct_excel', function (Blueprint $table) {
                $table->bigIncrements('a_stm_ct_excel_id');  
                $table->date('ct_date')->nullable();//   
                $table->Time('ct_timein')->nullable();//       
                $table->string('hn')->nullable();//  
                $table->string('an')->nullable();// 
                $table->string('cid')->nullable();//       
                $table->string('ptname')->nullable();//   
                $table->string('sfhname')->nullable();// ส่งจาก รพ.
                $table->string('typename')->nullable();// ในเวลา / นอกเวลา
                $table->string('pttypename')->nullable();// สิทธิ์การรักษา
                $table->string('pttypename_spsch')->nullable();// สิทธิ์การรักษา สปสช
                $table->string('hname')->nullable();//  รพ. ต้นสังกัด
                $table->string('cardno')->nullable();// เลขที่บัตร
                $table->string('ward')->nullable();// แผนก
                $table->string('service')->nullable();// Service
                $table->string('icode_hos')->nullable();// 
                $table->string('ct_check')->nullable();//   ส่วนตรวจ
                $table->string('price_check')->nullable();// ค่าตรวจ
                $table->string('total_price_check')->nullable();// รวมค่าตรวจ
                $table->string('opaque')->nullable();// สารทึบแสง
                $table->string('opaque_price')->nullable();// ค่าสารทึบแสง
                $table->string('total_opaque_price')->nullable();//รวมค่าสารทึบแสง
                $table->string('other')->nullable();// อื่นๆ
                $table->string('other_price')->nullable();// ค่าใช้จ่ายอื่นๆ
                $table->string('total_other_price')->nullable();// รวมค่าใช้จ่ายอื่นๆ
                $table->string('before_price')->nullable();// 
                $table->string('discount')->nullable();// ส่วนลด
                $table->string('vat')->nullable();// Vat
                $table->string('total')->nullable();// 
                $table->string('sumprice')->nullable();// ค่าใช้จ่ายรวม 
                $table->string('paid')->nullable();// ชำระแล้ว
                $table->string('remain')->nullable();// ค้างชำระ
                $table->string('doctor')->nullable();// แพทย์ผู้ส่ง
                $table->string('doctor_read')->nullable();// แพทย์ผู้อ่าน
                $table->string('technician')->nullable();//นักเทคนิคการแพทย์
                $table->string('technician_sub')->nullable();//ผู้ช่วย
                $table->string('nurse')->nullable();// 
                $table->string('icd9')->nullable();// 
                $table->string('user_id')->nullable();// 
                $table->string('STMDoc')->nullable();// 
                $table->string('vn')->nullable();//  HOS
                $table->string('hos_check')->nullable();//   ส่วนตรวจ HOS
                $table->string('hos_price_check')->nullable();// ค่าตรวจ HOS
                $table->string('hos_total_price_check')->nullable();// รวมค่าตรวจ HOS               
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_stm_ct_excel');
    }
};
