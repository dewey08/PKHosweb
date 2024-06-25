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
        if (!Schema::hasTable('warehouse_recieve'))
        {
            Schema::create('warehouse_recieve', function (Blueprint $table) {
                $table->bigIncrements('warehouse_recieve_id');
                $table->string('warehouse_recieve_code')->nullable();//เลขที่บิล
                $table->string('warehouse_recieve_no_bill')->nullable();//เลขที่เอกสาร
                $table->string('warehouse_recieve_po')->nullable();//เลขที่ PO :
                $table->string('warehouse_recieve_year')->nullable();//ปี
                $table->enum('warehouse_recieve_type', ['ASSET', 'STORE'])->default('STORE');
                $table->string('warehouse_recieve_user_id')->nullable();//ผู้รับ
                $table->string('warehouse_recieve_inven_id')->nullable();//รับเข้าคลัง
                $table->string('warehouse_recieve_vendor_id')->nullable();//ตัวแทนจำหน่าย
                $table->dateTime('warehouse_recieve_date')->nullable();//ลงวันที่เวลารับ
                // $table->Time('warehouse_recieve_time')->nullable();//ลงเวลารับ
                $table->string('warehouse_recieve_status')->nullable();  //สถานะ
                $table->enum('warehouse_recieve_send', ['STALE','WAIT', 'FINISH'])->default('WAIT'); //สถานะการส่ง
                $table->string('warehouse_recieve_total')->nullable();  //Totl
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
        Schema::dropIfExists('warehouse_recieve');
    }
};
