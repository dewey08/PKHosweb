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
        if (!Schema::hasTable('acc_stm_ti_total'))
        {
            Schema::connection('mysql')->create('acc_stm_ti_total', function (Blueprint $table) {
                $table->bigIncrements('acc_stm_ti_total_id'); 
                $table->string('acc_stm_ti_totalhead_id',100)->nullable();// 
                $table->string('repno',100)->nullable();//   
                $table->string('hn')->nullable();//   
                $table->string('cid')->nullable();//
                $table->string('fullname')->nullable();//ชื่อ-สกุล 
                $table->date('vstdate')->nullable();//วันที่เข้ารับบริการ 
                // $table->double('sum_price_approve', 12, 4)->nullable();//รวมจ่ายชดเชยสุทธิ 
                $table->date('date_save')->nullable();// 
                $table->string('station')->nullable();// 
                $table->string('vn')->nullable();//   
                $table->string('invno')->nullable();//  
                $table->string('dttran',255)->nullable();//   
                // $table->double('hdrate', 12, 4)->nullable();// 
                // $table->double('hdcharge', 12, 4)->nullable();// 
                // $table->double('amount', 12, 4)->nullable();// 
                // $table->double('paid', 12, 4)->nullable();// 
                // $table->double('EPOpay', 12, 4)->nullable();// 
                // $table->string('sum_price_approve')->nullable();// 
               

                $table->string('rid')->nullable();//  
                $table->string('accp')->nullable();//  
                $table->string('HDflag')->nullable();//   

                // $table->string('AccPeriod')->nullable();//  
                $table->string('hdrate')->nullable();// 
                $table->string('hdcharge')->nullable();// 
                $table->string('amount')->nullable();// 
                $table->string('paid')->nullable();// 
                $table->string('EPOpay')->nullable();// 
                $table->string('Total_amount')->nullable();//  
                // $table->string('Total_thamount')->nullable();//  
                $table->text('STMdoc',500)->nullable();//  
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
        Schema::dropIfExists('acc_stm_ti_total');
    }
};
