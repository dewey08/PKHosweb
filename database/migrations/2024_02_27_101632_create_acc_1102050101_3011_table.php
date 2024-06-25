<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {  
            
            if (!Schema::hasTable('acc_1102050101_3011'))
            {
                Schema::create('acc_1102050101_3011', function (Blueprint $table) {
                    $table->bigIncrements('acc_1102050101_3011_id'); 
                    $table->char('vn', length: 100)->nullable();// รหัส
                    $table->char('an', length: 100)->nullable();// 
                    $table->char('hn', length: 100)->nullable();// 
                    $table->char('cid', length: 100)->nullable();//  
                    $table->char('ptname', length: 100)->nullable();// 
                    $table->date('vstdate')->nullable();//
                    $table->Time('vsttime')->nullable();// 
                    $table->date('regdate')->nullable();//
                    $table->date('dchdate')->nullable();//            
                    $table->char('pttype', length: 100)->nullable();//  
                    $table->char('pttype_nhso', length: 100)->nullable();// 
                    $table->date('pttype_nhso_startdate')->nullable();//  
                    $table->char('acc_code', length: 100)->nullable();// 
                    $table->char('account_code', length: 100)->nullable();// 
                    $table->char('income', length: 100)->nullable();// 
                    $table->char('uc_money', length: 100)->nullable();// 
                    $table->char('discount_money', length: 100)->nullable();//  
                    $table->char('rcpt_money', length: 100)->nullable();//  paid_money
                    $table->char('rcpno', length: 100)->nullable();//  
                    $table->char('debit', length: 100)->nullable();// 
                    $table->char('debit_drug', length: 100)->nullable();//เฉพาะรายการยา
                    $table->char('debit_instument', length: 100)->nullable();// เฉพาะรอวัยวะเทียม
                    $table->char('debit_refer', length: 100)->nullable();// เฉพาะ Refer
                    $table->char('debit_toa', length: 100)->nullable();//
                    $table->char('debit_total', length: 100)->nullable();//
    
                    $table->char('debit_ins_sss', length: 100)->nullable();//
                    $table->char('debit_ct_sss', length: 100)->nullable();//
    
                    $table->char('max_debt_amount', length: 100)->nullable();//  
                    $table->char('acc_debtor_filename', length: 100)->nullable();// 
                    $table->char('stm_rep', length: 100)->nullable();//  
                    $table->char('stm_money', length: 100)->nullable();//                
                    $table->char('stm_uc_money', length: 100)->nullable();// 
                    $table->char('stm_rcpt_money', length: 100)->nullable();// 
                    $table->char('stm_rcpno', length: 100)->nullable();//  
                    $table->char('stm_rw', length: 100)->nullable();// 
                    $table->char('acc_debtor_userid', length: 100)->nullable();// 
                    $table->enum('status', ['Y', 'N'])->default('N');
                    $table->text('comment')->nullable();// 
                    $table->date('date_req')->nullable();// 
                    $table->string('STMdoc')->nullable();// 
                    $table->timestamps();
                });
                
            }
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acc_1102050101_3011');
    }
};
