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
        if (!Schema::hasTable('d_fdh'))
        {
            Schema::connection('mysql')->create('d_fdh', function (Blueprint $table) { 
                $table->bigIncrements('d_fdh_id');//  
                $table->enum('active', ['N','Y'])->default('N')->nullable();
                $table->string('vn')->nullable();//   
                $table->string('an')->nullable();//  
                $table->string('hn')->nullable();//  
                $table->string('cid')->nullable();//  
                $table->string('ptname')->nullable();//  
                $table->string('pttype')->nullable();// 
                $table->string('subinscl')->nullable();// 
                $table->date('vstdate')->nullable();//  
                $table->date('dchdate')->nullable();// 
                $table->string('authen')->nullable();// 
                $table->string('pdx')->nullable();// 
                $table->string('icd10')->nullable();// 
                $table->string('hospcode')->nullable();// 
                $table->string('hospmain')->nullable();// 
                $table->string('nhso_adp_code')->nullable();// 
                $table->string('projectcode')->nullable();// 
                $table->string('paid_money')->nullable();// ชำระเงินเอง
                $table->string('debit')->nullable();// 
                $table->string('price_ofc')->nullable();// 
                $table->string('AppKTB')->nullable();// 
                $table->string('edc')->nullable();// 
                $table->string('rcpno')->nullable();//ใบเสร็จ
                $table->string('rramont')->nullable();// ปิดลูกหนี้     
                $table->string('debit_drug')->nullable();// 
                $table->string('error_code')->nullable();// 
                $table->string('debit_rep')->nullable();// 
                $table->string('debit_stm')->nullable();// 
                $table->string('STMdoc')->nullable();// 
                $table->string('covid')->nullable();//
                $table->string('labcovid')->nullable();//
                $table->enum('ods', ['N','Y'])->default('N')->nullable();
                $table->string('error_c')->nullable();// 
                $table->string('cc')->nullable();//
                $table->string('transaction_uid')->nullable();//
                $table->string('id_booking')->nullable();// 
                $table->text('inst')->nullable();// 
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
        Schema::dropIfExists('d_fdh');
    }
};
