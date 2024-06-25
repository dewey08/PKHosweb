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
        if (!Schema::hasTable('fdh_noapprove_excel'))
        {
            Schema::connection('mysql')->create('fdh_noapprove_excel', function (Blueprint $table) {
                $table->bigIncrements('fdh_noapprove_excel_id');
                $table->string('hn')->nullable();//
                $table->string('vn')->nullable();//
                $table->string('an')->nullable();//
                $table->string('visit_type')->nullable();//
                $table->date('vstdate')->nullable();//วันเข้ารับบริการ
                $table->date('regdate')->nullable();//วันที่รับการรักษา
                $table->date('dchdate')->nullable();// วันจำหน่ายออก
                $table->string('UUC')->nullable();//  การใช้สิทธิ  1 ,2
                $table->datetime('datesend_spsch')->nullable();//วันที่ส่งหา สปสช.
                $table->string('uid')->nullable();//upload uid
                $table->string('hipdata_code')->nullable();//สิทธิ
                $table->string('error_code')->nullable();//        รหัสปฏิเสธ
                $table->string('error_detail')->nullable();//      คำอธิบายการปฏิเสธ
                $table->string('user_id')->nullable();//
                $table->string('nhso_reject')->nullable();//  
                $table->string('STMdoc')->nullable();//    
                $table->enum('active', ['N','Y'])->default('N'); 
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fdh_noapprove_excel');
    }
};
