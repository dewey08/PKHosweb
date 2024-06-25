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
        if (!Schema::hasTable('acc_1102050101_216'))
        {
            Schema::create('acc_1102050101_216', function (Blueprint $table) {
                $table->bigIncrements('acc_1102050101_216_id'); 
                $table->string('vn')->nullable();// รหัส
                $table->string('an')->nullable();// 
                $table->string('hn')->nullable();// 
                $table->string('cid')->nullable();//  
                $table->string('ptname')->nullable();// 
                $table->date('vstdate')->nullable();//
                $table->Time('vsttime')->nullable();// 
                $table->date('regdate')->nullable();//
                $table->date('dchdate')->nullable();//            
                $table->string('pttype')->nullable();//  
                $table->string('pttype_nhso')->nullable();// 
                $table->date('pttype_nhso_startdate')->nullable();// 
                $table->string('income_group')->nullable();// 
                $table->string('acc_code')->nullable();// 
                $table->string('account_code')->nullable();// 
                $table->string('income')->nullable();// 
                $table->string('uc_money')->nullable();// 
                $table->string('discount_money')->nullable();//  
                $table->string('rcpt_money')->nullable();//  paid_money
                $table->string('rcpno')->nullable();//  
                $table->string('debit')->nullable();// 
                $table->string('debit_drug')->nullable();//เฉพาะรายการยา
                $table->string('debit_instument')->nullable();// เฉพาะรอวัยวะเทียม
                $table->string('debit_refer')->nullable();// เฉพาะ Refer
                $table->string('debit_toa')->nullable();//
                $table->string('debit_total')->nullable();//    ลูกหนี้
                $table->string('max_debt_amount')->nullable();// 
                $table->string('rw')->nullable();// 
                $table->string('adjrw')->nullable();//                    adjrw
                $table->string('total_adjrw_income')->nullable();//       = adjrw * 8350,9000
                $table->string('sauntang')->nullable();//                 ส่วนต่าง
                $table->string('acc_debtor_filename')->nullable();// 
                $table->string('stm_rep')->nullable();//  
                $table->string('stm_money')->nullable();//                
                $table->string('stm_uc_money')->nullable();// 
                $table->string('stm_rcpt_money')->nullable();// 
                $table->string('stm_rcpno')->nullable();//  
                $table->string('stm_rw')->nullable();// 
                $table->string('acc_debtor_userid')->nullable();// 
                $table->enum('status', ['Y', 'N'])->default('N');
                $table->string('comment')->nullable();// 
                $table->date('date_req')->nullable();// 

                $table->string('stm_trainid')->nullable();// 
                $table->string('stm_total')->nullable();// 
                $table->string('va')->nullable();// 
                $table->string('STMdoc')->nullable();// 
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
        Schema::dropIfExists('acc_1102050101_216');
    }
};
