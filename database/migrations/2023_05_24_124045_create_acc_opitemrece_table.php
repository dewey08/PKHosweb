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
        if (!Schema::hasTable('acc_opitemrece'))
        {
            Schema::create('acc_opitemrece', function (Blueprint $table) {
                $table->bigIncrements('acc_opitemrece_id'); 
                $table->string('vn')->nullable();// รหัส
                $table->string('an')->nullable();// 
                $table->string('hn')->nullable();//                
                $table->date('vstdate')->nullable();//
                $table->date('rxdate')->nullable();//
                $table->date('dchdate')->nullable();//
                $table->string('drugusage')->nullable();// 
                $table->string('income')->nullable();//            
                $table->string('pttype')->nullable();//  
                $table->string('paidst')->nullable();//  
                $table->string('order_no')->nullable();// 
                $table->string('finance_number')->nullable();// 
                $table->string('icode')->nullable();// 
                $table->string('name')->nullable();//   
                $table->string('qty')->nullable();// 
                $table->string('cost')->nullable();// 
                $table->string('unitprice')->nullable();// 
                $table->string('discount')->nullable();//
                $table->string('sum_price')->nullable();// 
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
        Schema::dropIfExists('acc_opitemrece');
    }
};
