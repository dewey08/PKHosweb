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
        if (!Schema::hasTable('a_ct_scan'))
        {
            Schema::create('a_ct_scan', function (Blueprint $table) {
                $table->bigIncrements('a_ct_scan_id');      
                $table->string('vn')->nullable();//  
                $table->string('an')->nullable();// 
                $table->string('hn')->nullable();// 
                $table->string('cid')->nullable();//    
                $table->date('order_date')->nullable();//  
                $table->time('order_time')->nullable();// 
                $table->dateTime('order_date_time')->nullable();//    
                $table->date('request_date')->nullable();// 
                $table->string('ptname')->nullable();//  
                $table->string('xray_list')->nullable();//  
                $table->string('confirm_all')->nullable();//  
                $table->string('department')->nullable();//  
                $table->string('department_code')->nullable();//  
                $table->string('department_name')->nullable();//  
                $table->string('pttype')->nullable();//  
                $table->string('ptty_spsch')->nullable();// 
                $table->string('xray_order_number')->nullable();// 
                $table->string('xray_price')->nullable();// 
                $table->string('total_price')->nullable();// 
                $table->string('department_list')->nullable();// 
                $table->string('priority_name')->nullable();//  
                $table->string('STMdoc')->nullable();// 
                $table->string('user_id')->nullable();// 
                $table->string('hospcode')->nullable();// 
                $table->string('hospmain')->nullable();// 
                $table->string('referin_no')->nullable();// 
                $table->enum('active', ['N', 'Y', 'W'])->default('N');  
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_ct_scan');
    }
};
