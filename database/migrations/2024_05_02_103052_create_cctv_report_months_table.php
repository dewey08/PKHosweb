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
        if (!Schema::hasTable('cctv_report_months'))
        {
            Schema::connection('mysql')->create('cctv_report_months', function (Blueprint $table) { 
                $table->bigIncrements('cctv_report_months_id');//                 
                $table->date('cctv_check_date')->nullable();//  
                $table->string('article_num')->nullable();//  
                $table->string('screen_all')->nullable();//     
                $table->string('screen_narmal')->nullable();//  ปกติ
                $table->string('screen_abnarmal')->nullable();//    ผิดปกติ 
                $table->string('corner_all')->nullable();//
                $table->string('corner_narmal')->nullable();//  ปกติ
                $table->string('corner_abnarmal')->nullable();//    ผิดปกติ 
                $table->string('drawback_all')->nullable();//
                $table->string('drawback_narmal')->nullable();//  ปกติ
                $table->string('drawback_abnarmal')->nullable();//    ผิดปกติ 
                $table->string('csave_all')->nullable();//
                $table->string('csave_narmal')->nullable();//  ปกติ
                $table->string('csave_abnarmal')->nullable();//    ผิดปกติ 
                $table->string('power_all')->nullable();//
                $table->string('power_narmal')->nullable();//  ปกติ
                $table->string('power_abnarmal')->nullable();//    ผิดปกติ 
                $table->string('cctv_type')->nullable();// In /Out
                $table->string('cctv_location')->nullable();// ที่ตั้ง
                $table->date('datesave')->nullable();//  วั่นที่ส่ง 
                $table->string('user_id')->nullable();//  ผู้ส่ง
                $table->enum('active', ['N','Y'])->default('N')->nullable(); 
                $table->timestamps();
            }); 
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cctv_report_months');
    }
};
