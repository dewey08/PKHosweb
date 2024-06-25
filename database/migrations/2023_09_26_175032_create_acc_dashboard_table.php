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
        if (!Schema::connection('mysql')->hasTable('acc_dashboard'))
        {
            Schema::connection('mysql')->create('acc_dashboard', function (Blueprint $table) {
                $table->bigIncrements('acc_dashboard_id'); 
                $table->date('vstdate')->nullable();//  
                $table->string('months')->nullable();//
                $table->string('year')->nullable();//
                $table->string('hipdata_code')->nullable();//
                $table->string('count_vn')->nullable();//   
                $table->string('income')->nullable();//         visit all        opd 
                $table->string('discount_money')->nullable();//  
                $table->string('rcpt_money')->nullable();//  
                $table->string('debit')->nullable();// 

                $table->string('looknee_vn')->nullable();//         income looknee   opd
                $table->string('looknee_income')->nullable();// 
                $table->string('looknee_discount_money')->nullable();// 
                $table->string('looknee_rcpt_money')->nullable();// 
                $table->string('looknee_debit_total')->nullable();//    income looknee   opd
                
                $table->string('claim_vn')->nullable();//  
                $table->string('claim_income')->nullable();//            claim qty        opd
                $table->string('claim_debit_total')->nullable();//       claim stm    opd
                
                $table->string('claim_stm_opd')->nullable();//       claim stm    opd

                $table->string('count_an')->nullable();//            visit all          ipd
                $table->string('looknee_an')->nullable();//          income looknee   ipd
                $table->string('looknee_sum_ipd')->nullable();//     income looknee   ipd
                $table->string('claim_an')->nullable();//            claim qty         ipd
                $table->string('claim_sum_ipd')->nullable();//       claim stm    ipd
                $table->string('claim_stm_ipd')->nullable();//       claim qty      ipd
     
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
        Schema::dropIfExists('acc_dashboard');
    }
};
