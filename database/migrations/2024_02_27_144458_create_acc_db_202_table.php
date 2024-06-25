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
        if (!Schema::hasTable('acc_db_202'))
        {
            Schema::create('acc_db_202', function (Blueprint $table) {
                $table->bigIncrements('acc_db_202_id');  
                $table->string('days')->nullable();// 
                $table->string('months')->nullable();// 
                $table->string('years')->nullable();//  
                $table->string('MONTH_NAME')->nullable();// 
                $table->string('count_tongtung_an')->nullable();// 
                $table->string('count_vn')->nullable();// 
                $table->string('count_an')->nullable();// 
                $table->string('count_vn_stm')->nullable();// 
                $table->string('count_an_stm')->nullable();//  
                $table->string('count_vn_forward')->nullable();// 
                $table->string('count_an_forward')->nullable();// 
                $table->double('debit_tontung', 12, 2)->nullable();  //  ต้องตั้ง         
                $table->double('debit_total', 12, 2)->nullable();  //  ลูกหนี้
                $table->double('ip_paytrue', 12, 2)->nullable();   //   STM
                $table->double('total_forward', 12, 2)->nullable();//  ยอดยกไป
                $table->dateTime('last_update')->nullable();// 
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
        Schema::dropIfExists('acc_db_202');
    }
};
