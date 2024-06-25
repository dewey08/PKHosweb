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
        if (!Schema::hasTable('account_main'))
        {
        Schema::create('account_main', function (Blueprint $table) {
            $table->bigIncrements('account_main_id');  
            $table->date('account_main_date')->nullable();// วันที่  
            $table->Time('account_main_time')->nullable();// เวลา  
            $table->string('account_main_mounts',255)->nullable();// เดือน
            $table->string('account_main_year',255)->nullable();// ปี
            $table->string('account_main_type',255)->nullable();// ประเภท
            $table->string('cid',255)->nullable();// เลขบัตร ปชช
            $table->string('person_name',255)->nullable();//  ชื่อ-สกุล
            $table->string('acc',255)->nullable();//  เลขที่บัญชี 
            $table->string('salary',255)->nullable();//  เงินเดือน
            $table->double('backpay', 10, 2)->nullable();// ตกเบิก
            $table->double('positionpay', 10, 2)->nullable();// ปจต.
            $table->double('a0811', 10, 2)->nullable();// '8-11
            $table->double('cost_of_living', 10, 2)->nullable();// 'ครองชีพ
            $table->double('a24percent', 10, 2)->nullable();// '2%4%
            $table->double('ot', 10, 2)->nullable();// ot
            $table->double('revenue_sum', 10, 2)->nullable();// รวมรับ
            $table->enum('account_rep_active', ['TAKEDOWN','MANAGE','REQUEST','CHECK','FINISH','CANCEL','REPFINISH','COPYREQUEST'])->default('MANAGE')->nullable();
            $table->double('tax', 10, 2)->nullable();// ภาษี
            $table->double('fund', 10, 2)->nullable();// กบข./กสจ./สมทบ
            $table->double('fundbackpay', 10, 2)->nullable();// กบข.
            $table->double('add', 10, 2)->nullable();// ส่วนเพิ่ม
            $table->double('installment', 10, 2)->nullable();// ผ่อน
            $table->double('flat', 10, 2)->nullable();// แฟลต
            $table->double('share', 10, 2)->nullable();// หุ้น
            $table->double('loan', 10, 2)->nullable();// กู้
            $table->double('food', 10, 2)->nullable();// คืน สสจ
            $table->double('water', 10, 2)->nullable();// ค่าน้ำ
            $table->double('electric', 10, 2)->nullable();//ค่าไฟ
            $table->double('coop', 10, 2)->nullable();//สหกรณ์
            $table->double('F24', 10, 2)->nullable();//ฌกส.
            $table->double('F25', 10, 2)->nullable();//ธอส
            $table->double('F26', 10, 2)->nullable();//ประกัน
            $table->double('F27', 10, 2)->nullable();//KTB
            $table->double('F28', 10, 2)->nullable();//GSB
            $table->double('F29', 10, 2)->nullable();//SCB
            $table->double('other', 10, 2)->nullable();//กยศ./อื่นๆ
            $table->double('expend_sum', 10, 2)->nullable();//รวมจ่าย
            $table->double('balance', 10, 2)->nullable();//คงเหลือรับ
            $table->string('store_id',255)->nullable();// รพ
            $table->enum('account_pay_active', ['TAKEDOWN','MANAGE','REQUEST','CHECK','FINISH','CANCEL','PAYFINISH','COPYREQUEST'])->default('MANAGE')->nullable();
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
        Schema::dropIfExists('account_main');
    }
};
