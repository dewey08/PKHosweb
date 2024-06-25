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
        if (!Schema::hasTable('medical_borrow'))
        {
        Schema::create('medical_borrow', function (Blueprint $table) {
            $table->bigIncrements('medical_borrow_id'); 
            $table->date('medical_borrow_date')->nullable();// วันที่ยืม
            $table->date('medical_borrow_backdate')->nullable();// วันที่คืน
            $table->string('medical_borrow_article_id')->nullable();//  รายการ
            $table->string('medical_borrow_qty')->nullable();//  จำนวน
            $table->string('medical_borrow_fromdebsubsub_id')->nullable();//  จากหน่วยงาน
            $table->string('medical_borrow_debsubsub_id')->nullable();//  หน่วยงานที่ยืม
            $table->string('medical_borrow_users_id')->nullable();// ผู้บันทึก
            $table->string('medical_borrow_backusers_id')->nullable();// ผู้ส่งคืน
            $table->string('medical_borrow_typecat_id')->nullable();//  ประเภทเครื่องมือ
            $table->enum('medical_borrow_active', ['REQUEST','APPROVE','CANCEL','SENDEB'])->default('REQUEST')->nullable();
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
        Schema::dropIfExists('medical_borrow');
    }
};
