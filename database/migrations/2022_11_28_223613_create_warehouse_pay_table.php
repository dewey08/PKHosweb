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
        if (!Schema::hasTable('warehouse_pay'))
        {
        Schema::create('warehouse_pay', function (Blueprint $table) {
            $table->bigIncrements('warehouse_pay_id');
            $table->string('warehouse_pay_code')->nullable();//เลขที่บิล
            $table->string('warehouse_pay_no_bill')->nullable();//เลขที่เอกสาร
            $table->string('warehouse_pay_po')->nullable();//เลขที่ PO :
            $table->string('warehouse_pay_year')->nullable();//ปี 
            $table->enum('warehouse_pay_type', ['ASSET', 'STORE'])->default('STORE');
            $table->string('warehouse_pay_fromuser_id')->nullable();//ผู้จ่าย
            $table->string('warehouse_pay_repuser_id')->nullable();//ผู้รับ
            $table->string('warehouse_pay_inven_id')->nullable();//รับเข้าคลัง
            $table->string('warehouse_pay_frominven_id')->nullable();//จากคลัง    
            $table->dateTime('warehouse_pay_date')->nullable();//ลงวันที่เวลาจ่าย            
            $table->string('warehouse_pay_status')->nullable();  //สถานะ  
            $table->string('warehouse_pay_send')->nullable();  //สถานะการส่ง 
            $table->string('warehouse_pay_total')->nullable();  //Totl  
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
        Schema::dropIfExists('warehouse_pay');
    }
};
