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
        if (!Schema::hasTable('acc_debtor_stamp'))
        {
            Schema::create('acc_debtor_stamp', function (Blueprint $table) {
                $table->bigIncrements('acc_debtor_stamp_id'); 
                $table->string('stamp_vn')->nullable();// รหัส
                $table->string('stamp_an')->nullable();// 
                $table->string('stamp_hn')->nullable();// 
                $table->string('stamp_cid')->nullable();//  
                $table->string('stamp_ptname')->nullable();// 
                $table->date('stamp_vstdate')->nullable();//
                $table->Time('stamp_vsttime')->nullable();// 
                $table->date('stamp_dchdate')->nullable();//
            
                $table->string('stamp_pttype')->nullable();//  
                $table->string('stamp_pttype_nhso')->nullable();// 
                $table->date('stamp_pttype_nhso_startdate')->nullable();// 
                $table->string('stamp_acc_code')->nullable();// 
                $table->string('stamp_account_code')->nullable();// 

                $table->string('stamp_income')->nullable();// 
                $table->string('stamp_uc_money')->nullable();// 
                $table->string('stamp_discount_money')->nullable();// 
                $table->string('stamp_paid_money')->nullable();// 
                $table->string('stamp_rcpt_money')->nullable();// 
                $table->string('stamp_rcpno')->nullable();//  
                $table->string('stamp_debit')->nullable();// 
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
        Schema::dropIfExists('acc_debtor_stamp');
    }
};
