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
        if (!Schema::hasTable('ssop_billitems'))
        {
            Schema::connection('mysql')->create('ssop_billitems', function (Blueprint $table) {
                $table->bigIncrements('ssop_billitems_id');
                $table->string('Invno')->nullable();//   
                $table->string('SvDate')->nullable();// 
                $table->string('BillMuad')->nullable();// 
                $table->string('LCCode')->nullable();// 
                $table->string('STDCode')->nullable();// 
                $table->string('Desc')->nullable();// 
                $table->double('QTY', 10, 2)->nullable();// 
                $table->double('UnitPrice', 10, 2)->nullable();// 
                $table->double('ChargeAmt', 10, 2)->nullable();// 
                $table->double('ClaimUP', 10, 2)->nullable();// 
                $table->double('ClaimAmount', 10, 2)->nullable();//  
                $table->string('SvRefID')->nullable();// 
                $table->string('ClaimCat')->nullable();// 
                $table->string('paidst')->nullable();//    
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
        Schema::dropIfExists('ssop_billitems');
    }
};
