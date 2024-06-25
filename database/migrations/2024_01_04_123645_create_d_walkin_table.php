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
        if (!Schema::hasTable('d_walkin'))
        {
            Schema::connection('mysql')->create('d_walkin', function (Blueprint $table) { 
                $table->bigIncrements('d_walkin_id');//  
                $table->enum('active', ['N','Y'])->default('N')->nullable();
                $table->string('vn')->nullable();//   
                $table->string('an')->nullable();//  
                $table->string('hn')->nullable();// 
                $table->string('cid')->nullable();//  
                $table->string('pttype')->nullable();// 
                $table->date('vstdate')->nullable();// 
                $table->string('authen')->nullable();// 
                $table->string('icd10')->nullable();// 
                $table->string('ptname')->nullable();// 
                $table->string('hospcode')->nullable();// 
                $table->string('hospcode_name')->nullable();// 
                $table->string('er_emergency_level_name')->nullable();// 
                $table->string('income')->nullable();//  
                $table->string('uc_money')->nullable();// 
                $table->string('paid_money')->nullable();// 
                $table->string('rcpt_money')->nullable();//                  
                $table->timestamps();
            }); 
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('d_walkin');
    }
};
