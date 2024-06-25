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
        if (!Schema::hasTable('acc_stm_ti_excel'))
        {
            Schema::connection('mysql')->create('acc_stm_ti_excel', function (Blueprint $table) {
                $table->bigIncrements('acc_stm_ti_excel_id'); 
                $table->string('repno',100)->nullable();//  
                $table->string('tranid')->nullable();//   
                $table->string('hn')->nullable();//   
                $table->string('an')->nullable();// 
                $table->string('cid')->nullable();//
                $table->string('fullname')->nullable();//ชื่อ-สกุล 
                $table->string('hipdata_code')->nullable();//
                $table->string('hcode')->nullable();//
                $table->date('regdate')->nullable();//วันที่ลงทะเบียน
                $table->date('vstdate')->nullable();//วันที่เข้ารับบริการ  
                $table->string('no')->nullable();// 
                $table->string('list')->nullable();//   
                $table->string('qty')->nullable();//   
                $table->string('unitprice')->nullable();// 
                $table->string('unitprice_max')->nullable();// 
                $table->string('price_request')->nullable();// 
                $table->string('pscode')->nullable();//  
                $table->string('percent')->nullable();// 
                $table->string('pay_amount')->nullable();//  
                $table->string('nonpay_amount')->nullable();// 
                $table->string('payplus_amount')->nullable();//   
                $table->string('payback_amount')->nullable();//  
                $table->enum('active', ['REP','APPROVE','CANCEL','FINISH'])->default('APPROVE')->nullable(); 
                $table->string('filename',255)->nullable();// 
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
        Schema::dropIfExists('acc_stm_ti_excel');
    }
};
