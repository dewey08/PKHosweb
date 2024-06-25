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
        if (!Schema::hasTable('acc_106_debt_print'))
        {
            Schema::create('acc_106_debt_print', function (Blueprint $table) {
                $table->bigIncrements('acc_106_debt_print_id');
                $table->string('acc_1102050102_106_id')->nullable();// 
                $table->string('acc_106_debt_no')->nullable();// เลขที่
                $table->string('acc_106_debt_count')->nullable();//จำนวนครั้ง
                $table->date('acc_106_debt_date')->nullable();// วันที่ตาม
                $table->string('acc_106_debt_user')->nullable();// 
                $table->text('acc_106_debt_address')->nullable();// ที่อยู่
                $table->text('tmb_name')->nullable();// 
                $table->text('amphur_name')->nullable();// 
                $table->text('chw_name')->nullable();// 
                $table->text('provincode')->nullable();// 
                $table->string('vn')->nullable();// รหัส
                $table->string('an')->nullable();//
                $table->string('hn')->nullable();//
                $table->string('cid')->nullable();//
                $table->string('ptname')->nullable();//
                $table->date('vstdate')->nullable();// 
                $table->date('dchdate')->nullable();//
                $table->string('pttype')->nullable();// 
                $table->string('income')->nullable();// 
                $table->string('discount_money')->nullable();//
                $table->string('paid_money')->nullable();//
                $table->string('rcpt_money')->nullable();//  paid_money
                $table->string('rcpno')->nullable();// 
                $table->string('debit_total')->nullable();// 
                $table->string('debit_total_thai')->nullable();//
               
                $table->enum('status', ['Y', 'N'])->default('N');   
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
        Schema::dropIfExists('acc_106_debt_print');
    }
};
