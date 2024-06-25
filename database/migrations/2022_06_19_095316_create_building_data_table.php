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
        if (!Schema::hasTable('building_data'))
        {
        Schema::create('building_data', function (Blueprint $table) {
            $table->bigIncrements('building_id');
            $table->string('building_name')->nullable();//ชื่ออาคาร
            // $table->string('building_name')->nullable();//งบประมาณ
            $table->string('building_decline_id')->nullable();//ประเภทค่าเสื่อม
            $table->string('building_decline_name')->nullable();//ประเภทค่าเสื่อม
            $table->string('building_land_id')->nullable();  //ไอดีหมายเลขระวาง
            $table->string('building_tonnage_number')->nullable();  //หมายเลขระวาง
            $table->string('building_budget_id')->nullable();  //งบประมาณ
            $table->string('building_budget_name')->nullable();  //งบประมาณ
            $table->string('building_method_id')->nullable();//วิธีได้มา
            $table->string('building_method_name')->nullable();//วิธีได้มา
            $table->string('building_buy_id')->nullable();//วิธีการซื้อ
            $table->string('building_buy_name')->nullable();//วิธีการซื้อ
            $table->string('building_budget_price')->nullable();  //งบประมาณที่สร้าง
            $table->string('building_amount')->nullable();  //จำนวน
            $table->string('building_long')->nullable();  //อายุใช้งาน
            $table->date('building_creation_date')->nullable();  //วันที่เริ่มสร้าง
            $table->date('building_completion_date')->nullable();  //วันที่แล้วเสร็จ
            $table->date('building_delivery_date')->nullable();  //วันที่ส่งมอบ
            $table->string('building_userid')->nullable();  //ผู้รับผิดชอบ
            $table->string('building_username')->nullable();  //ผู้รับผิดชอบ
            $table->string('building_tel')->nullable();  //เบอร์ติดต่อ
            $table->string('building_engineer')->nullable();  //วิศวกร
            $table->binary('building_img')->nullable();
            $table->string('building_img_name')->nullable();
            $table->binary('building_type_id')->nullable();
            $table->string('building_type_name')->nullable();
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
        Schema::dropIfExists('building_data');
    }
};
