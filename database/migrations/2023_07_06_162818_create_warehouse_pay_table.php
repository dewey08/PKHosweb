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
                $table->string('pay_code')->nullable();//เลขที่บิล
                $table->string('pay_year')->nullable();//ปี
                $table->enum('pay_type', ['ASSET', 'STORE'])->default('STORE');
                $table->string('pay_user_id')->nullable();//ผู้รับ
                $table->string('pay_payuser_id')->nullable();//ผู้จ่าย
                $table->string('payin_inven_id')->nullable();//รับเข้าคลัง
                $table->string('payout_inven_id')->nullable();//จ่ายจากคลัง
                $table->string('pay_vendor_id')->nullable();//ตัวแทนจำหน่าย
                $table->date('pay_date')->nullable();//ลงวันที่เวลารับ
                $table->Time('pay_time')->nullable();//ลงเวลารับ
                $table->string('pay_status')->nullable();  //สถานะ
                $table->enum('pay_send', ['STALE','WAIT', 'FINISH'])->default('WAIT'); //สถานะการส่ง
                $table->string('pay_total')->nullable();  //Totl
                $table->string('store_id')->nullable();
                $table->string('pay_repaire_no')->nullable();  //ใบแจ้งซ่อม
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
