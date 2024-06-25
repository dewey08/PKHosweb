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
        if (!Schema::hasTable('acc_stm_sss'))
        {
            Schema::create('acc_stm_sss', function (Blueprint $table) {
                $table->bigIncrements('acc_stm_sss_id'); 
                $table->string('acc_stm_sss_head_id')->nullable();//  ไอดี head
                $table->string('HCare')->nullable();//  
                $table->string('HMain')->nullable();// 
                $table->string('HN')->nullable();// 
                $table->string('InvNo')->nullable();//  
                $table->string('PID')->nullable();//  
                $table->string('Name')->nullable();// 
                $table->string('DTtran')->nullable();//            
                $table->string('CP')->nullable();//  
                $table->string('BP')->nullable();//   
                $table->string('BF')->nullable();// 
                $table->string('CA')->nullable();// 
                $table->string('Due')->nullable();// 
                $table->string('RID')->nullable();// 
                $table->string('Copay')->nullable();// 
                $table->string('Amount')->nullable();//  
                $table->string('Stat')->nullable();//    
                $table->enum('status', ['Y', 'N'])->default('N'); 
                $table->string('user_id')->nullable();// 
                $table->string('STMdoc')->nullable();// 
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acc_stm_sss');
    }
};
