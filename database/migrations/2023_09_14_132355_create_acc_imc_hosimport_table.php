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
        if (!Schema::hasTable('acc_imc_hosimport'))
        {
            Schema::connection('mysql')->create('acc_imc_hosimport', function (Blueprint $table) { 
                $table->bigIncrements('acc_imc_hosimport_id');//  
                $table->string('vn')->nullable();//   
                $table->string('an')->nullable();//  
                $table->string('hn')->nullable();//  
                $table->string('ptname')->nullable();//  
                $table->date('vstdate')->nullable();// 
                $table->date('dchdate')->nullable();//   
                $table->string('income')->nullable();//
                $table->string('paid_money')->nullable();//
                $table->string('debit')->nullable();//  
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
        Schema::dropIfExists('acc_imc_hosimport');
    }
};
