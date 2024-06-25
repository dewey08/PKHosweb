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
        if (!Schema::hasTable('d_crrt_main'))
        {
            Schema::connection('mysql')->create('d_crrt_main', function (Blueprint $table) { 
                $table->bigIncrements('d_crrt_main_id');//  
                $table->string('vn')->nullable();//   
                $table->string('an')->nullable();//  
                $table->string('hn')->nullable();// 
                $table->string('cid')->nullable();// 
                $table->string('ptname')->nullable();//  
                $table->string('pttype')->nullable();// 
                $table->date('vstdate')->nullable();// 
                $table->time('vsttime')->nullable();// 
                $table->string('authen')->nullable();// 
                $table->string('rxdate')->nullable();//  
                $table->time('rxtime')->nullable();//  
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
        Schema::dropIfExists('d_crrt_main');
    }
};
