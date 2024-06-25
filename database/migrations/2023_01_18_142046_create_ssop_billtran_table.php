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
        if (!Schema::hasTable('ssop_billtran'))
        {
            Schema::connection('mysql')->create('ssop_billtran', function (Blueprint $table) {
                $table->bigIncrements('ssop_billtran_id');
                $table->string('Station')->nullable();//   
                $table->string('Authencode')->nullable();// 
                $table->date('vstdate')->nullable();// 
                $table->string('DTtran')->nullable();// 
                $table->string('Hcode')->nullable();// 
                $table->string('Invno')->nullable();// 
                $table->string('VerCode')->nullable();// 
                $table->string('Tflag')->nullable();// 
                $table->string('HMain')->nullable();// 
                $table->string('HN')->nullable();// 
                $table->string('Pid')->nullable();// 
                $table->string('Name')->nullable();// 
               
                $table->double('Amount', 10, 2)->nullable();// 
                $table->double('Paid', 10, 2)->nullable();// 
                $table->double('ClaimAmt', 10, 2)->nullable();// 
                $table->double('PayPlan', 10, 2)->nullable();// 
                $table->double('OtherPay', 10, 2)->nullable();// 
                $table->string('OtherPayplan')->nullable();//   
                $table->string('pttype')->nullable();// 
                $table->string('Diag')->nullable();// 
  
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
        Schema::dropIfExists('ssop_billtran');
    }
};
