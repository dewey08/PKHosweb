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
        if (!Schema::hasTable('a_stm_ct_finish'))
        {
            Schema::create('a_stm_ct_finish', function (Blueprint $table) {
                $table->bigIncrements('a_stm_ct_finish_id'); 
                $table->string('a_stm_ct_id');       
                $table->string('hn')->nullable();//  
                $table->string('vn')->nullable();//
                $table->string('an')->nullable();// 
                $table->string('cid')->nullable();//       
                $table->string('ptname')->nullable();//    
                $table->string('user_id')->nullable();// ผู้ตรวจ  
                $table->enum('active', ['N', 'Y', 'E'])->default('Y'); 
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_stm_ct_finish');
    }
};
