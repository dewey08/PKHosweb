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
        if (!Schema::hasTable('d_ofc_402'))
        {
            Schema::connection('mysql')->create('d_ofc_402', function (Blueprint $table) { 
                $table->bigIncrements('d_ofc_402_id');// 
                $table->enum('active', ['N','Y'])->default('N')->nullable(); 
                $table->string('vn')->nullable();//   
                $table->string('an')->nullable();//  
                $table->string('hn')->nullable();// 
                $table->string('cid')->nullable();//  
                $table->string('pttype')->nullable();// 
                $table->date('dchdate')->nullable();// 
                $table->string('claim_code')->nullable();// 
                $table->string('icd10')->nullable();// 
                $table->string('ptname')->nullable();// 
                $table->string('instument')->nullable();// 
                $table->string('income')->nullable();// 
                $table->string('paid_money')->nullable();// 
                $table->string('uc_money')->nullable();// 
                $table->string('rfrocs')->nullable();// 
                $table->string('rfrolct')->nullable();// 
                $table->string('covid')->nullable();// 
                $table->string('lab')->nullable();// 
                $table->timestamps();
            }); 
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('d_ofc_402');
    }
};
