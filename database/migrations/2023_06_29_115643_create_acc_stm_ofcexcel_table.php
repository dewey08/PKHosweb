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
        if (!Schema::hasTable('acc_stm_ofcexcel'))
        {
            Schema::connection('mysql')->create('acc_stm_ofcexcel', function (Blueprint $table) {
                $table->bigIncrements('acc_stm_ofcexcel_id'); 
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
                $table->string('STMdoc')->nullable();//  
                $table->enum('active', ['REP','APPROVE','CANCEL','FINISH'])->default('REP')->nullable(); 
                // $table->timestamps();
                $table->timestamp(column:'created_at')->useCurrent();
                $table->timestamp(column:'updated_at')->nullable();
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
        Schema::dropIfExists('acc_stm_ofcexcel');
    }
};
