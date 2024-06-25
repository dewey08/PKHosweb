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
        if (!Schema::hasTable('report_hos'))
        {
            Schema::connection('mysql')->create('report_hos', function (Blueprint $table) { 
                $table->bigIncrements('report_hos_id');//  
                $table->string('report_hos_name')->nullable();//   
                $table->enum('active', ['N', 'Y'])->default('Y');  
                $table->string('report_department_sub')->nullable();// 
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
        Schema::dropIfExists('report_hos');
    }
};
