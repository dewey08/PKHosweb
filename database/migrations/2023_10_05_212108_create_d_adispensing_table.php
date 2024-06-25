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
        if (!Schema::hasTable('d_adispensing'))
        {
            Schema::connection('mysql')->create('d_adispensing', function (Blueprint $table) {
                $table->bigIncrements('d_adispensing_id');
                $table->string('ProviderID')->nullable();//   
                $table->string('DispID')->nullable();// 
                $table->string('Invno')->nullable();// 
                $table->string('HN')->nullable();// 
                $table->string('PID')->nullable();// 
                $table->string('Prescdt')->nullable();// 
                $table->string('Dispdt')->nullable();//  
                $table->string('Prescb')->nullable();// 
                $table->string('Itemcnt')->nullable();// 
                $table->double('ChargeAmt', 10, 2)->nullable();// 
                $table->double('ClaimAmt', 10, 2)->nullable();// 
                $table->double('Paid', 10, 2)->nullable();// 
                $table->double('OtherPay', 10, 2)->nullable();// 
                $table->string('Reimburser')->nullable();// 
                $table->string('BenefitPlan')->nullable();// 
                $table->string('DispeStat')->nullable();// 
                $table->string('SvID')->nullable();// 
                $table->string('DayCover')->nullable();// 

     
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
        Schema::dropIfExists('d_adispensing');
    }
};
