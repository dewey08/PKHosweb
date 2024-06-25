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
        if (!Schema::hasTable('pttype_acc'))
        {
            Schema::connection('mysql10')->create('pttype_acc', function (Blueprint $table) {
                $table->bigIncrements('pttype_acc_id');                  
                $table->string('pttype')->nullable();//   
                $table->string('name')->nullable();//  
                $table->string('pcode')->nullable();//  
                $table->string('paidst')->nullable();//
                $table->string('hipdata_code')->nullable();//  
                $table->string('max_debt_money')->nullable();//  
                $table->string('pttype_eclaim_id')->nullable();//  
                
                $table->enum('active', ['TRUE','FALSE'])->default('TRUE')->nullable(); 
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
        Schema::dropIfExists('pttype_acc');
    }
};
