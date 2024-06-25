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
        if (!Schema::hasTable('article_data'))
        {
        Schema::create('article_data', function (Blueprint $table) {
            $table->bigIncrements('article_id');
            $table->string('article_fsn')->nullable();  //เลขหมวดครุภัณฑ์
            $table->string('article_num')->nullable();  //เลขครุภัณฑ์
            $table->string('article_name')->nullable();  //ชื่อครุภัณฑ์
            $table->string('article_attribute')->nullable(); //คุณลักษณะ
            $table->double('article_price', 10, 2)->nullable();//ราคา
            $table->string('article_year')->nullable(); //ปีงบประมาณ
            $table->date('article_recieve_date')->nullable();//วันที่รับเข้า
            $table->string('article_spypriceid')->nullable(); //ราคาสืบ
            $table->string('article_spypricename')->nullable(); //ชื่อราคาสืบ
            $table->string('article_register')->nullable(); //เลขทะเบียน

            $table->string('medical_typecat_id')->nullable(); //ประเภทเครื่องมือ

            $table->string('article_typeid')->nullable(); //ประเภทครุภัณฑ์
            $table->string('article_typename')->nullable(); //ชื่อประเภทครุภัณฑ์
            $table->string('article_categoryid')->nullable(); //หวมดครุภัณฑ์
            $table->string('article_categoryname')->nullable(); //ชื่อหวมดครุภัณฑ์
            $table->string('article_groupid')->nullable();//ชนิดวัสดุ
            $table->string('article_groupname')->nullable();//ชื่อชนิดวัสดุ

            $table->string('article_method_id')->nullable();//วิธีได้มา
            $table->string('article_buy_id')->nullable();//การจัดซื้อ
            $table->string('article_buy_name')->nullable();//การจัดซื้อ
            $table->string('article_budget_id')->nullable();//งบที่ใช้
            $table->string('article_decline_id')->nullable();//ประเภทค่าเสื่อม
            $table->string('article_decline_name')->nullable();//ประเภทค่าเสื่อม
            $table->string('article_vendor_id')->nullable();//ผู้จำหน่าย
            $table->string('article_vendor_name')->nullable();//ผู้จำหน่าย
            $table->string('article_deb_subsub_id')->nullable();//ประจำหน่วยงาน
            $table->string('article_deb_subsub_name')->nullable();//ประจำหน่วยงาน

            $table->string('article_car_type_id')->nullable();//ประเภทรถยนต์
            $table->string('article_car_type_name')->nullable();//ประเภทรถยนต์
            $table->string('article_car_number')->nullable();//เลขตัวรถยนต์
            $table->string('article_serial_no')->nullable();//เลขเครื่อง
            $table->string('article_car_gas')->nullable();//เลขถังแก๊ส

            $table->string('article_status_id')->nullable();//สถานะการใช้งาน
            $table->string('article_status_name')->nullable();//สถานะการใช้งาน

            $table->string('article_room_id')->nullable();//ห้อง
            $table->string('article_user_id')->nullable();//ผู้รับผิดชอบ
            $table->string('article_user_name')->nullable();//ผู้รับผิดชอบ
            $table->string('article_long_id')->nullable();//อายุการใช้งาน
            $table->date('article_exp_id')->nullable();//หมดสภาพ

            $table->string('article_model_id')->nullable();//รุ่น
            $table->string('article_model_name')->nullable();//รุ่น
            $table->string('article_color_id')->nullable();//สี
            $table->string('article_color_name')->nullable();//สี
            $table->string('article_serial')->nullable();//เลขเครื่อง
            $table->string('article_brand_id')->nullable();//ยี่ห้อ
            $table->string('article_brand_name')->nullable();//ยี่ห้อ
            $table->string('article_size_id')->nullable();//ขนาด

            $table->string('article_unit_id')->nullable(); //หน่วย
            $table->string('article_unit_name')->nullable(); //ชื่อหน่วย

            $table->string('article_used')->nullable();//ใช้บ่อย

            $table->binary('article_img')->nullable();
            $table->string('article_img_name')->nullable();
            $table->string('store_id')->nullable();
            $table->enum('article_claim', ['CLAIM', 'NOCLAIM'])->default('NOCLAIM')->nullable();//ส่งเคลมใด้
            $table->string('article_group_id')->nullable(); //แยกชนิดให้ รพ ภูเขียว
            $table->string('article_used')->nullable();
            $table->string('medical_typecat_id')->nullable(); //
            $table->string('article_type_id')->nullable(); // 
            $table->string('cctv')->nullable(); // 
            $table->string('cctv_location')->nullable(); // ตำแหน่งกล้องวงจรปิด
            $table->string('cctv_location_detail')->nullable(); // รัศมีครอบคลุม
            $table->string('cctv_type')->nullable(); // ชนิด
            $table->string('cctv_code')->nullable(); // รหัสกล้อง
            $table->string('cctv_monitor')->nullable(); // หมายเหตุ/ช่องในจอ
            $table->enum('cctv_status', ['0', '1'])->default('0')->nullable();//
            $table->timestamps('created_at')->useCurrent();
            $table->timestamps('updated_at')->nullable();
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
        Schema::dropIfExists('article_data');
    }
};
