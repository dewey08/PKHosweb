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
        if (!Schema::hasTable('acc_imc_hos'))
        {
            Schema::connection('mysql')->create('acc_imc_hos', function (Blueprint $table) { 
                $table->bigIncrements('acc_imc_hos_id');//  
                $table->string('vn')->nullable();//   
                $table->string('an')->nullable();//  
                $table->string('hn')->nullable();// 
                $table->string('cid')->nullable();// 
                $table->string('ptname')->nullable();//  
                $table->string('icd10')->nullable();//  
                $table->string('pttype')->nullable();//
                $table->date('vstdate')->nullable();// 
                $table->date('dchdate')->nullable();//   
                $table->date('regdate')->nullable();//  
                $table->Time('vsttime')->nullable();//  
                $table->Time('regtime')->nullable();// 
                $table->string('income')->nullable();//
                $table->string('paid_money')->nullable();//
                $table->string('debit')->nullable();//  
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
        Schema::dropIfExists('acc_imc_hos');
    }
};
