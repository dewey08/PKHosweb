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
        if (!Schema::hasTable('account_monthlydebt'))
        {
        Schema::create('account_monthlydebt', function (Blueprint $table) {
            $table->bigIncrements('account_monthlydebt_id');  
            $table->date('account_monthlydebt_date')->nullable();// วันที่  
            $table->Time('account_monthlydebt_time')->nullable();// เวลา  
            $table->string('account_monthlydebt_mounts',255)->nullable();// เดือน
            $table->string('account_monthlydebt_year',255)->nullable();// ปี
            $table->string('account_monthlydebt_type',255)->nullable();// ประเภท
            $table->string('cid',255)->nullable();// เลขบัตร ปชช
            $table->string('person_name',255)->nullable();//  ชื่อ-สกุล

            $table->string('shk_code',255)->nullable();//  สหกรณ์ออมทรัพย์  
            $table->double('shk_price', 10, 2)->nullable();//  สหกรณ์ออมทรัพย์

            $table->string('tos_code',255)->nullable();// ธนาคารอาคารสงเคราะห์  
            $table->double('tos_price', 10, 2)->nullable();// ธนาคารอาคารสงเคราะห์

            $table->string('os_code',255)->nullable();//    ธนาคารออมสิน  
            $table->double('os_price', 10, 2)->nullable();//    ธนาคารออมสิน

            $table->string('ktb_code',255)->nullable();//       ธนาคารกรุงไทย  
            $table->double('ktb_price', 10, 2)->nullable();//       ธนาคารกรุงไทย

            $table->string('cremation_code',255)->nullable();//        ฌาปนกิจ  
            $table->double('cremation_price', 10, 2)->nullable();//        ฌาปนกิจ

            $table->string('other_code',255)->nullable();//         หนี้สินอื่น ๆ   
            $table->double('other_price', 10, 2)->nullable();//         หนี้สินอื่น ๆ 

            $table->string('scb_code',255)->nullable();//        ธนาคารไทยพาณิชย์  
            $table->double('scb_price', 10, 2)->nullable();//        ธนาคารไทยพาณิชย์
 
            $table->enum('account_monthlydebt_active', ['WAIT','MANAGE','REQUEST','CHECK','FINISH','CANCEL','REPFINISH'])->default('MANAGE')->nullable();
            $table->string('account_monthlydebt_usersave',255)->nullable();// ผู้บันทึก
            $table->string('store_id',255)->nullable();// รพ
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
        Schema::dropIfExists('account_monthlydebt');
    }
};
