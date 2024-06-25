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
        if (!Schema::hasTable('d_hpv_report'))
        {
            Schema::connection('mysql')->create('d_hpv_report', function (Blueprint $table) { 
                $table->bigIncrements('d_hpv_report_id');//  
                $table->string('vn')->nullable();//    
                $table->string('hn')->nullable();// 
                $table->string('cid')->nullable();//  
                $table->string('pttype')->nullable();// 
                $table->date('vstdate')->nullable();//   
                $table->string('ptname')->nullable();//  
                $table->string('icode')->nullable();//  
                $table->string('dname')->nullable();// 
                $table->string('qty')->nullable();// 
                $table->string('unitprice')->nullable();// 
                $table->string('sum_price')->nullable();//   
                $table->string('debit')->nullable();//
                $table->string('pp')->nullable();// 
                $table->string('fs')->nullable();//
                $table->string('total_approve')->nullable();//   
                $table->string('va')->nullable();//   
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
        Schema::dropIfExists('d_hpv_report');
    }
};
