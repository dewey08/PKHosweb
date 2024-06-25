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
        if (!Schema::hasTable('warehouse_rep'))
        {
        Schema::create('warehouse_rep', function (Blueprint $table) {
            $table->bigIncrements('warehouse_rep_id');
            $table->string('warehouse_rep_code')->nullable();//เลขที่บิล
            $table->string('warehouse_rep_no_bill')->nullable();//เลขที่เอกสาร
            $table->string('warehouse_rep_po')->nullable();//เลขที่ PO :
            $table->string('warehouse_rep_year')->nullable();//ปี
            $table->enum('warehouse_rep_type', ['ASSET', 'STORE'])->default('STORE');
            $table->string('warehouse_rep_user_id')->nullable();//ผู้รับ
            $table->string('warehouse_rep_user_name')->nullable();//ผู้รับ
            $table->string('warehouse_rep_inven_id')->nullable();//รับเข้าคลัง
            $table->string('warehouse_rep_inven_name')->nullable();//รับเข้าคลัง
            $table->string('warehouse_rep_vendor_id')->nullable();//ตัวแทนจำหน่าย
            $table->string('warehouse_rep_vendor_name')->nullable();//ตัวแทนจำหน่าย
            $table->dateTime('warehouse_rep_date')->nullable();//ลงวันที่เวลารับ
            // $table->Time('warehouse_rep_time')->nullable();//ลงเวลารับ
            $table->string('warehouse_rep_status')->nullable();  //สถานะ

            $table->enum('warehouse_rep_send', ['STALE','WAIT', 'FINISH'])->default('WAIT'); //สถานะการส่ง

            $table->string('warehouse_rep_total')->nullable();  //Totl
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
        Schema::dropIfExists('warehouse_rep');
    }
};
