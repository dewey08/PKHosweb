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
        if (!Schema::hasTable('acc_stm_ofc'))
        {
            Schema::connection('mysql')->create('acc_stm_ofc', function (Blueprint $table) {
                $table->bigIncrements('acc_stm_ofc_id'); 
                $table->string('repno',100)->nullable();//   
                $table->string('no')->nullable();// 
                $table->string('hn')->nullable();//   
                $table->string('an')->nullable();//  
                $table->string('cid')->nullable();//
                $table->string('fullname')->nullable();//ชื่อ-สกุล 
                $table->date('vstdate')->nullable();//วันที่เข้ารับบริการ  
                $table->date('dchdate')->nullable();// 
                $table->string('PROJCODE')->nullable();// 
                $table->string('AdjRW')->nullable();//   
                $table->string('price_req')->nullable();//  
                $table->string('prb',255)->nullable();//     
                $table->string('room')->nullable();//  
                $table->string('inst')->nullable();//  
                $table->string('drug')->nullable();//    
                $table->string('income')->nullable();// 
                $table->string('refer')->nullable();// 
                $table->string('waitdch')->nullable();// 
                $table->string('service')->nullable();// 
                $table->string('pricereq_all')->nullable();//   
                $table->string('type')->nullable();//
                $table->string('STMdoc')->nullable();//  
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
        Schema::dropIfExists('acc_stm_ofc');
    }
};
