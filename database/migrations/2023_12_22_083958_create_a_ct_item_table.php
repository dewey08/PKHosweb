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
        if (!Schema::hasTable('a_ct_item'))
        {
            Schema::create('a_ct_item', function (Blueprint $table) {
                $table->bigIncrements('a_ct_item_id');   
                $table->string('vn')->nullable();//  
                $table->string('hn')->nullable();// 
                $table->string('cid')->nullable();//    
                $table->date('vstdate')->nullable();//    
                $table->string('icode')->nullable();//  
                $table->string('ctname')->nullable();//  
                $table->string('xray_items_code')->nullable();//  
                $table->string('xray_icode')->nullable();//   
                $table->string('qty')->nullable();// 
                $table->string('unitprice')->nullable();//  
                $table->string('sum_price')->nullable();// 
                $table->string('user_id')->nullable();// 
                
                $table->string('sfhname')->nullable();//  
                $table->string('pttypename')->nullable();// 
                $table->string('ward')->nullable();// 
                $table->string('icode_hos')->nullable();// 
                $table->string('ct_check')->nullable();// 
                $table->string('price_check')->nullable();// 
                $table->string('total_price_check')->nullable();// 
                $table->string('opaque')->nullable();// 
                $table->string('opaque_price')->nullable();// 
                $table->string('total_opaque_price')->nullable();// 
                $table->string('other_price')->nullable();// 
                $table->string('total_other_price')->nullable();// 
                $table->string('before_price')->nullable();// 
                $table->string('discount')->nullable();// 
                $table->string('vat')->nullable();// 
                $table->string('total')->nullable();// 
                $table->string('sumprice')->nullable();// 
                $table->string('paid')->nullable();// 
                $table->string('remain')->nullable();// 
                $table->string('STMDoc')->nullable();// 

                 
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_ct_item');
    }
};
