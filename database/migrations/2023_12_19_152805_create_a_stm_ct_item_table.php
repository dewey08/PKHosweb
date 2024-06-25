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
        if (!Schema::hasTable('a_stm_ct_item'))
        {
            Schema::create('a_stm_ct_item', function (Blueprint $table) {
                $table->bigIncrements('a_stm_ct_item_id');  
                $table->date('ct_date')->nullable();//        
                $table->string('hn')->nullable();//  
                $table->string('an')->nullable();// 
                $table->string('cid')->nullable();//       
                $table->string('ptname')->nullable();//    
                $table->string('ct_check')->nullable();//   ส่วนตรวจ
                $table->string('ct_check_hos')->nullable();//   ส่วนตรวจ hos
                $table->string('price_check')->nullable();// ค่าตรวจ
                $table->string('total_price_check')->nullable();// รวมค่าตรวจ 
                $table->string('opaque_price')->nullable();// ค่าสารทึบแสง
                $table->string('total_opaque_price')->nullable();//รวมค่าสารทึบแสง  
                $table->string('before_price')->nullable();// 
                $table->string('discount')->nullable();// ส่วนลด
                $table->string('vat')->nullable();// Vat
                $table->string('total')->nullable();// 
                $table->string('sumprice')->nullable();// ค่าใช้จ่ายรวม 
                $table->string('paid')->nullable();// ชำระแล้ว
                $table->string('remain')->nullable();// ค้างชำระ 
                $table->string('user_id')->nullable();//   
                $table->string('STMDoc')->nullable();//   
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_stm_ct_item');
    }
};
