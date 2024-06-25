<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        if (!Schema::hasTable('acc_1102050101_217_sub'))
        {
            Schema::create('acc_1102050101_217_sub', function (Blueprint $table) {
                $table->bigIncrements('acc_1102050101_217_sub_id');  
                $table->string('acc_1102050101_217_id');  //acc_1102050101_217 id
                $table->string('an')->nullable();//  
                $table->date('dchdate')->nullable();//    
                $table->string('income')->nullable();// 
                $table->string('icode')->nullable();//  
                $table->string('name')->nullable();//  
                $table->string('qty')->nullable();// 
                $table->string('cost')->nullable();// 
                $table->string('unitprice')->nullable();// 
                $table->string('discount')->nullable();//
                $table->string('sum_price')->nullable();// 
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acc_1102050101_217_sub');
    }
};
