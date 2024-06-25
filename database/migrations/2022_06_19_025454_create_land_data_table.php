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
        if (!Schema::hasTable('land_data'))
        {
        Schema::create('land_data', function (Blueprint $table) {
            $table->bigIncrements('land_id');
            $table->string('land_tonnage_number')->nullable();  //หมายเลขระวาง
            $table->string('land_no')->nullable();  //เลขที่
            $table->string('land_tonnage_no')->nullable();  //เลขโฉนดที่ดิน  เลขที่ดิน
            $table->string('land_explore_page')->nullable(); //หน้าสำรวจ
            $table->string('land_house_number')->nullable();//ที่ตั้งบ้านเลขที่ 
            $table->string('land_province_location')->nullable(); //ที่ตั้งจังหวัด
            $table->string('land_province_location_name')->nullable(); //ที่ตั้งจังหวัด

            $table->string('land_district_location')->nullable();//ที่ตั้งอำเภอ
            $table->string('land_district_location_name')->nullable();//ที่ตั้งอำเภอ

            $table->string('land_tumbon_location')->nullable(); //ที่ตั้งตำบล
            $table->string('land_tumbon_location_name')->nullable(); //ที่ตั้งตำบล

            $table->string('land_poscode')->nullable(); //ไปรษณีย์
            $table->string('land_farm_area')->nullable(); //เนื้อที่ไร่
            $table->string('land_work_area')->nullable(); //เนื้อที่งาน
            $table->string('land_square_wah_area')->nullable(); //เนื้อที่ตารางวา
            $table->string('land_holder_name')->nullable(); //ชื่อผู้ถือครอง
            $table->date('land_date')->nullable();//วันถือครอง
            $table->string('land_latitude')->nullable();//พิกัดละติจูด    
            $table->string('land_longitude')->nullable();//พิกัดลองจิจูด    
            $table->string('land_land_office')->nullable();//สำนักงานที่ดิน  
            $table->string('land_file')->nullable();//File  
            $table->binary('land_img')->nullable();//โฉนด 
            $table->string('land_img_name')->nullable();//File   
            $table->string('store_id')->nullable();//File     
            $table->string('land_user_id')->nullable();//ผู้รับผิดชอบ  
            $table->string('land_user_name')->nullable();//ผู้รับผิดชอบ  
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
        Schema::dropIfExists('land_data');
    }
};
