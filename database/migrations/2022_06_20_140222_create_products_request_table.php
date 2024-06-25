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
        if (!Schema::hasTable('products_request'))
        {
        Schema::create('products_request', function (Blueprint $table) {
            $table->bigIncrements('request_id');
            $table->string('request_code')->nullable();//รหัสบิล
            $table->string('request_year')->nullable();//ปีงบประมาณ 
            $table->date('request_date')->nullable();//ลงวันที่ต้องการ 
            $table->string('request_because_buy')->nullable();//เพื่อจัดซื้อ/ซ่อมแซม  
            $table->string('request_debsubsub_id')->nullable();//หน่วยงานผู้เบิก  
            $table->string('request_debsubsub_name')->nullable();
            $table->string('request_phone')->nullable();//เบอร์โทร 
            $table->string('request_because')->nullable();//เหตุผล 
            $table->string('request_vendor_id')->nullable();//ตัวแทนจำหน่าย 
            $table->string('request_vendor_name')->nullable();//ตัวแทนจำหน่าย 
            $table->string('request_user_id')->nullable();//ผู้รายงาน 
            $table->string('request_user_name')->nullable();//
            $table->string('request_hn_id')->nullable();//ผู้เห็นชอบ 
            $table->string('request_hn_name')->nullable();
            $table->string('request_hn_date')->nullable();//วันที่เห็นชอบ 
            $table->string('request_check_id')->nullable();//ผู้ตรวจสอบ 
            $table->string('request_check_name')->nullable();
            $table->string('request_check_date')->nullable();//วันที่ตรวจสอบ 
            $table->string('request_po_id')->nullable();//ผู้อนุมัติ
            $table->string('request_po_name')->nullable();   
            $table->string('request_po_date')->nullable();  //วันที่อนุมัติ  
            $table->string('request_status')->nullable();  //สถานะ  
            $table->string('store_id')->nullable();  
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
        Schema::dropIfExists('products_request');
    }
};
