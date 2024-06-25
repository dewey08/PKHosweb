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
        if (!Schema::hasTable('a_ct_scan_visit'))
        {
            Schema::create('a_ct_scan_visit', function (Blueprint $table) {
                $table->bigIncrements('a_ct_scan_visit_id');      
                $table->string('vn')->nullable();//  
                $table->string('an')->nullable();// 
                $table->string('hn')->nullable();// 
                $table->string('cid')->nullable();//    
                $table->date('vstdate')->nullable();//    
                $table->string('ptname')->nullable();//  
                $table->string('xray_list')->nullable();//  
                $table->string('qty')->nullable();//  
                $table->string('paidst')->nullable();//  
                $table->string('unitprice')->nullable();//  
                $table->string('sum_price')->nullable();//   
                $table->string('user_id')->nullable();// 
                $table->longText('cc')->nullable();// 
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
        Schema::dropIfExists('a_ct_scan_visit');
    }
};
