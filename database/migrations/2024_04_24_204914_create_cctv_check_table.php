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
        if (!Schema::hasTable('cctv_check'))
        {
            Schema::create('cctv_check', function (Blueprint $table) {
                $table->bigIncrements('cctv_check_id'); 
                $table->string('article_num')->nullable();  //เลขครุภัณฑ์ รหัส : OUT CO1
                $table->date('cctv_check_date')->nullable();  //ชื่อครุภัณฑ์         
                $table->string('cctv_camera_screen')->nullable(); // จอกล้อง
                $table->string('cctv_camera_corner')->nullable(); // มุมกล้อง
                $table->string('cctv_camera_drawback')->nullable(); // สิ่งกีดขวาง
                $table->string('cctv_camera_save')->nullable(); // การบันทึก
                $table->string('cctv_camera_power_backup')->nullable(); // การสำรองไฟ
                $table->string('cctv_user_id')->nullable(); // ผู้ตรวจ
                
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cctv_check');
    }
};
