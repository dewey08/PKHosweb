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
        if (!Schema::hasTable('d_tb_main'))
        {
            Schema::connection('mysql')->create('d_tb_main', function (Blueprint $table) { 
                $table->bigIncrements('d_tb_main_id');// 
                $table->string('group_code')->nullable();//  
                $table->string('group_screen')->nullable();//   
                $table->string('vn')->nullable();//  
                $table->string('ovn')->nullable();// 
                $table->string('hn')->nullable();//  
                $table->string('cid')->nullable();//   
                $table->string('age')->nullable();//  
                $table->text('address')->nullable();//  
                $table->date('vstdate')->nullable();// 
                $table->string('ptname')->nullable();// 
                $table->string('pdx')->nullable();// 
                $table->string('pttype')->nullable();// 
                $table->string('icode')->nullable();//       
                $table->string('nname')->nullable();// 
                $table->string('income')->nullable();// 
                $table->string('inc04')->nullable();// 
                $table->string('user_id')->nullable();//         
                $table->timestamps();
            });    
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('d_tb_main');
    }
};
