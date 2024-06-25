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
        if (!Schema::hasTable('d_talassemia'))
        {
            Schema::connection('mysql')->create('d_talassemia', function (Blueprint $table) { 
                $table->bigIncrements('d_talassemia_id');//  
                $table->string('vn')->nullable();//   
                $table->string('hn')->nullable();// 
                $table->string('an')->nullable();// 
                $table->string('cid')->nullable();//  
                $table->string('ptname')->nullable();//  
                $table->date('vstdate')->nullable();//  
                $table->date('dchdate')->nullable();//
                $table->string('pttype')->nullable();//  
                $table->string('icd10')->nullable();// 
                $table->string('icode')->nullable();// 
                $table->string('drugname')->nullable();// 
                $table->string('sum_price')->nullable();//
                $table->string('ferritin')->nullable();//   
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
        Schema::dropIfExists('d_talassemia');
    }
};
