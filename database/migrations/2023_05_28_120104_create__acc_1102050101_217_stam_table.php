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
        if (!Schema::hasTable('acc_1102050101_217_stam'))
        {
            Schema::create('acc_1102050101_217_stam', function (Blueprint $table) {
                $table->bigIncrements('acc_1102050101_217_stam_id'); 
                $table->string('vn')->nullable();// รหัส
                $table->string('an')->nullable();// 
                $table->string('hn')->nullable();// 
                $table->string('cid')->nullable();//  
                $table->string('ptname')->nullable();// 
                $table->date('vstdate')->nullable();// 
                $table->date('regdate')->nullable();//
                $table->date('dchdate')->nullable();//            
                $table->string('pttype')->nullable();//   
                $table->string('income_group')->nullable();//  
                $table->string('account_code')->nullable();//  
                $table->string('debit')->nullable();//  
                $table->string('debit_total')->nullable();// 
                $table->string('acc_debtor_userid')->nullable();// 
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
        Schema::dropIfExists('_acc_1102050101_217_stam');
    }
};
