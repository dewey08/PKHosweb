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
        if (!Schema::hasTable('com_repaire_signature'))
        {
        Schema::create('com_repaire_signature', function (Blueprint $table) {
            $table->bigIncrements('signature_id');    
            $table->string('com_repaire_id')->nullable();// 
            $table->string('com_repaire_no')->nullable();//  
            $table->text('signature_name_usertext')->nullable();//ผู้รองขอ
            $table->text('signature_name_reptext')->nullable();//ผู้รับงาน
            $table->text('signature_name_stafftext')->nullable();//ผู้ดูแลงาน
            $table->text('signature_name_hntext')->nullable();//หัวหน้า 
            $table->text('signature_name_grouptext')->nullable();//หัวหน้ากลุ่ม 
            $table->text('signature_name_rongtext')->nullable();//หัวหน้าบริหาร 
            $table->text('signature_name_potext')->nullable();//ผอ 
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
        Schema::dropIfExists('com_repaire_signature');
    }
};
