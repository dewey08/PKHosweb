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
        if (!Schema::hasTable('fire_check'))
        {
            Schema::create('fire_check', function (Blueprint $table) {
                $table->bigIncrements('fire_check_id'); 
                $table->string('fire_num')->nullable();  //เลขครุภัณฑ์ รหัส : OUT CO1
                $table->string('fire_name')->nullable(); 
                $table->string('fire_check_color')->nullable(); // 
                $table->string('fire_check_location')->nullable(); // 
                $table->date('check_date')->nullable();  //          
                $table->text('fire_check_injection')->nullable(); // 1.สายฉีด
                $table->text('fire_check_injection_name')->nullable(); //
                $table->text('fire_check_joystick')->nullable(); // 2.คันบังคับ
                $table->text('fire_check_joystick_name')->nullable(); //
                $table->text('fire_check_body')->nullable(); // 3.ตัวถัง
                $table->text('fire_check_body_name')->nullable(); // 
                $table->text('fire_check_gauge')->nullable(); // 4.เกจความดัน
                $table->text('fire_check_gauge_name')->nullable(); // 
                $table->text('fire_check_drawback')->nullable(); // 5.สิ่งกีดขวาง
                $table->text('fire_check_drawback_name')->nullable(); //
                $table->string('user_id')->nullable(); // ผู้ตรวจ
                
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fire_check');
    }
};
