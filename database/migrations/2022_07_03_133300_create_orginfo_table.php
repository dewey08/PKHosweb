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
        if (!Schema::hasTable('orginfo'))
        {
        Schema::create('orginfo', function (Blueprint $table) {
            $table->bigIncrements('orginfo_id');
            $table->string('orginfo_name',255)->nullable();//  ชื่อ รพ.
            $table->string('orginfo_code',255)->nullable();// รหัส รพ.
            $table->string('orginfo_manage_id',255)->nullable();// หัวหน้าบริหาร
            $table->string('orginfo_manage_name',255)->nullable();//หัวหน้าบริหาร 
            $table->string('orginfo_rongbo_id',255)->nullable();// ผู้แทน ผอ
            $table->string('orginfo_rongbo_name',255)->nullable();//ผู้แทน ผอ   
            $table->string('orginfo_po_id',255)->nullable();// ผอ.
            $table->string('orginfo_po_name',255)->nullable();//ผอ. 
            $table->string('orginfo_link',255)->nullable();//ลิ้งค์ 
            $table->string('orginfo_email',255)->nullable();// 
            $table->string('orginfo_address',255)->nullable();// 
            $table->string('orginfo_tel',255)->nullable();// 
            $table->binary('orginfo_img')->nullable();//
            $table->binary('orginfo_img_name')->nullable();//
            $table->string('host',255)->nullable();// 
            $table->string('port',255)->nullable();// 
            $table->string('username',255)->nullable();// 
            $table->string('password',255)->nullable();// 
            $table->string('dbname',255)->nullable();// 
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
        Schema::dropIfExists('orginfo');
    }
};
