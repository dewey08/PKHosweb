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
        if (!Schema::hasTable('d_opitemrece'))
        {
            Schema::connection('mysql')->create('d_opitemrece', function (Blueprint $table) { 
                $table->bigIncrements('d_opitemrece_id');//  
                $table->string('vn')->nullable();//   
                $table->string('an')->nullable();//  
                $table->string('hn')->nullable();// 
                $table->string('icode')->nullable();// 
                $table->string('qty')->nullable();// 
                $table->string('unitprice')->nullable();//   
                $table->date('vstdate')->nullable();// 
                $table->date('rxdate')->nullable();// 
                $table->string('income')->nullable();// 
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
        Schema::dropIfExists('d_opitemrece');
    }
};
