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
        if (!Schema::hasTable('acc_stm_sss_head'))
        {
            Schema::create('acc_stm_sss_head', function (Blueprint $table) {
                $table->bigIncrements('acc_stm_sss_head_id'); 
                $table->string('stmAccountID')->nullable();// รหัส
                $table->string('hcode')->nullable();// 
                $table->string('hname')->nullable();// 
                $table->string('AccPeriod')->nullable();//  
                $table->string('STMdoc')->nullable();//  
                $table->string('dateStart')->nullable();// 
                $table->string('dateEnd')->nullable();//            
                $table->string('dateDue')->nullable();//  
                $table->string('dateIssue')->nullable();//   
                $table->string('acount')->nullable();// 
                $table->string('amount')->nullable();// 
                $table->string('thamount')->nullable();//  
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acc_stm_sss_head');
    }
};
