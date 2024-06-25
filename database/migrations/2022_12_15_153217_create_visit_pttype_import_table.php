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
        if (!Schema::hasTable('visit_pttype_import'))
        {
        Schema::create('visit_pttype_import', function (Blueprint $table) {
            $table->bigIncrements('visit_pttype_import_id');  
                $table->string('hcode')->nullable();// 
                $table->string('hosname')->nullable();// 
                $table->string('cid')->nullable();// 
                $table->string('fullname')->nullable();// 
                $table->string('birthday')->nullable();// 
                $table->string('homtel')->nullable();// 
                $table->string('mainpttype')->nullable();// 
                $table->string('subpttype')->nullable();// 
                $table->string('repcode')->nullable();// 
                $table->string('claimcode')->nullable();// 
                $table->string('claimtype')->nullable();// 
                $table->string('servicerep')->nullable();// 
                $table->string('servicename')->nullable();// 
                $table->string('hncode')->nullable();// 
                $table->string('ancode')->nullable();// 
                $table->date('vstdate')->nullable();// วันที่เข้ารับบริการ
                $table->dateTime('regdate')->nullable();// วันที่บันทึก Authen Code
                $table->string('status')->nullable();//
                $table->string('repauthen')->nullable();//
                $table->string('authentication')->nullable();//วิธีการพิสูจน์ตัวตน
                $table->string('staffservice')->nullable();//
                $table->date('dateeditauthen')->nullable();//วันที่แก้ไข Authen Cod
                $table->string('nameeditauthen')->nullable();//ชื่อผู้ที่แก้ใข Authen Code
                $table->string('comment')->nullable();
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
        Schema::dropIfExists('visit_pttype_import');
    }
};
