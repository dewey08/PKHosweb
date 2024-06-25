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
        if (!Schema::hasTable('acc_stm_prb'))
        {
            Schema::connection('mysql')->create('acc_stm_prb', function (Blueprint $table) {
                $table->bigIncrements('acc_stm_prb_id');  
                $table->string('acc_1102050102_602_sid',100)->nullable();//
                $table->string('acc_1102050102_603_sid',100)->nullable();//
                $table->string('vn',100)->nullable();//
                $table->string('hn',100)->nullable();//
                $table->string('cid',100)->nullable();//
                $table->string('ptname',100)->nullable();//
                $table->string('req_no',100)->nullable();// รับแจ้ง  
                $table->string('claim_no')->nullable();// เคลม
                $table->string('vendor')->nullable();// บริษัทประกันภัย
                $table->string('pid')->nullable();// ผู้ประสบภัย 
                $table->string('fullname')->nullable();// ผู้ประสบภัย 
                $table->string('no')->nullable();// ครั้งที่
                $table->string('payprice')->nullable();//จำนวนเงิน
                $table->date('paydate')->nullable();//วันที่จ่าย
                $table->string('paytype')->nullable();// ประเภทการจ่าย
                $table->date('savedate')->nullable();// วันที่บันทึก
                $table->string('money_billno')->nullable();// เลขที่ใบเสร็จรับเงิน
                $table->string('usersave')->nullable();//  ผู้บันทึก
                $table->enum('active', ['REP','APPROVE','CANCEL','FINISH'])->default('REP')->nullable(); 
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
        Schema::dropIfExists('acc_stm_prb');
    }
};
