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
        if (!Schema::hasTable('d_ucep24'))
        {
            Schema::connection('mysql')->create('d_ucep24', function (Blueprint $table) { 
                $table->bigIncrements('d_ucep24_id');//  
                $table->string('vn')->nullable();//   
                $table->string('an')->nullable();//  
                $table->string('hn')->nullable();//  
                $table->string('cid')->nullable();//  
                $table->string('ptname')->nullable();//                 
                $table->string('pttype')->nullable();//   
                $table->string('hipdata_code')->nullable();//  
                $table->date('vstdate')->nullable();//   
                $table->date('rxdate')->nullable();// 
                $table->date('dchdate')->nullable();// 
                $table->string('icode')->nullable();// 
                $table->string('name')->nullable();// 
                $table->string('qty')->nullable();// 
                $table->string('unitprice')->nullable();// 
                $table->string('sum_price')->nullable();// 
                $table->string('user_id')->nullable(); //  
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
        Schema::dropIfExists('d_ucep24');
    }
};
