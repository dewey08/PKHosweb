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
        if (!Schema::hasTable('acc_stm_ti_totalhead'))
        {
            Schema::create('acc_stm_ti_totalhead', function (Blueprint $table) {
                $table->bigIncrements('acc_stm_ti_totalhead_id'); 
                $table->string('stmAccountID')->nullable();// รหัส
                $table->string('hcode')->nullable();// 
                $table->string('hname')->nullable();// 
                $table->string('AccPeriod')->nullable();//  
                $table->string('STMdoc')->nullable();// 
                $table->string('dateStart')->nullable();// 
                $table->string('dateEnd')->nullable();//
                $table->string('dateData')->nullable();//            
                $table->string('dateIssue')->nullable();// 
                $table->string('acount')->nullable();//  
                $table->string('amount')->nullable();// 
                $table->string('thamount')->nullable();// 
                $table->string('gst')->nullable();//    
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
        Schema::dropIfExists('acc_stm_ti_totalhead');
    }
};
