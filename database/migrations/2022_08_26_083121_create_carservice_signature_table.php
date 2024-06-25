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
        if (!Schema::hasTable('carservice_signature'))
        {
        Schema::create('carservice_signature', function (Blueprint $table) {
            $table->bigIncrements('signature_id');    
            $table->string('car_service_id')->nullable();// 
            $table->string('car_service_no')->nullable();//  
            $table->text('signature_name_usertext')->nullable();//ผู้รองขอ
            $table->text('signature_name_stafftext')->nullable();//ผู้รองขอ
            $table->text('signature_name_hntext')->nullable();//หัวหน้า 
            $table->text('signature_name_grouptext')->nullable();//หัวหน้ากลุ่ม 
            $table->text('signature_name_rongtext')->nullable();//หัวหน้าบริหาร 
            $table->text('signature_name_potext')->nullable();//ผอ
            $table->binary('signature_file')->nullable();// 
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
        Schema::dropIfExists('carservice_signature');
    }
};
