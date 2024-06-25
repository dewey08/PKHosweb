<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    { 
        if (!Schema::hasTable('d_homeward_main'))
        {
            Schema::create('d_homeward_main', function (Blueprint $table) {
                $table->bigIncrements('d_homeward_main_id'); 
                $table->string('an')->nullable();// 
                $table->string('vn')->nullable();//   
                $table->string('hn')->nullable();//   
                $table->string('cid')->nullable();//               
                $table->string('pttype')->nullable();//   
                $table->string('ptname')->nullable();// 
                $table->date('dchdate')->nullable();// 
                $table->time('dchtime')->nullable();//  
                $table->string('prediag')->nullable();//   
                $table->string('ward')->nullable();//   
                $table->string('adjrw')->nullable();//   
                $table->string('icd10')->nullable();//   
                $table->string('icdname')->nullable();//   
                $table->string('income')->nullable();//   
                $table->string('wait_paid_money')->nullable();//   
                $table->string('rcpt_money')->nullable();// 
                $table->string('admdoctor_name')->nullable();// 
                $table->string('dchtype_name')->nullable();// 
                $table->string('dchstts_name')->nullable();// 
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('d_homeward_main');
    }
};
