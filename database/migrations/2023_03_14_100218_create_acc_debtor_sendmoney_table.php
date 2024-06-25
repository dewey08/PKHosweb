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
        if (!Schema::hasTable('acc_debtor_sendmoney'))
        {
            Schema::create('acc_debtor_sendmoney', function (Blueprint $table) {
                $table->bigIncrements('acc_debtor_sendmoney_id'); 
                $table->string('send_vn')->nullable();// รหัส
                $table->string('send_an')->nullable();// 
                $table->string('send_hn')->nullable();// 
                $table->string('send_cid')->nullable();//  
                $table->string('send_ptname')->nullable();// 
                $table->date('send_vstdate')->nullable();//
                $table->Time('send_vsttime')->nullable();// 
                $table->date('send_dchdate')->nullable();//            
                $table->string('send_pttype')->nullable();//  
                $table->string('send_pttype_nhso')->nullable();// 
                $table->date('send_pttype_nhso_startdate')->nullable();// 
                $table->string('send_acc_code')->nullable();// 
                $table->string('send_account_code')->nullable();// 
                $table->string('send_income')->nullable();// 
                $table->string('send_uc_money')->nullable();// 
                $table->string('send_discount_money')->nullable();// 
                $table->string('send_paid_money')->nullable();// 
                $table->string('send_rcpt_money')->nullable();// 
                $table->string('send_rcpno')->nullable();//  
                $table->string('send_debit')->nullable();// 
                
                $table->string('max_debt_amount')->nullable();// 
                $table->string('acc_debtor_filename')->nullable();// 
                $table->string('stm_rep')->nullable();//  
                $table->string('stm_money')->nullable();//                
                $table->string('stm_uc_money')->nullable();// 
                $table->string('stm_rcpt_money')->nullable();// 
                $table->string('stm_rcpno')->nullable();//  
                $table->string('stm_rw')->nullable();// 

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
        Schema::dropIfExists('acc_debtor_sendmoney');
    }
};
