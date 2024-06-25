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
        // if (!Schema::hasTable('a_ovst'))
        // {
        //     Schema::connection('mysql')->create('a_ovst', function (Blueprint $table) { 
        //         $table->string('hos_guid',38)->nullable();//  pri 1 
        //         $table->string('vn',13)->nullable();//   
        //         $table->string('hn',9)->nullable();// 
        //         // $table->string('an',9)->nullable();// 
        //         $table->date('vstdate')->nullable();// 
        //         $table->time('vsttime')->nullable();//    
        //         $table->string('doctor',7)->nullable();// 
        //         $table->string('hospmain',5)->nullable();// 
        //         $table->string('hospsub',5)->nullable();// 
        //         $table->integer('oqueue',11)->nullable();// 
        //         $table->char('ovstist',2)->nullable();// 
        //         $table->string('ovstost',4)->nullable();// 
        //         $table->char('pttype',2)->nullable();// 
        //         $table->string('pttypeno',50)->nullable();// 
        //         $table->char('rfrics',1)->nullable();// 
        //         $table->string('rfrilct',5)->nullable();// 
        //         $table->char('rfrocs',1)->nullable();// 
        //         $table->string('rfrolct',5)->nullable();// 
        //         $table->char('spclty',2)->nullable();// 
        //         $table->string('rcpt_disease',100)->nullable();// 

        //         $table->string('hcode',5)->nullable();// 
        //         $table->char('cur_dep',3)->nullable();// 
        //         $table->char('cur_dep_busy',1)->nullable();// 
        //         $table->char('last_dep',3)->nullable();// 
        //         $table->time('cur_dep_time')->nullable();// 
        //         $table->integer('rx_queue',11)->nullable();// 
        //         $table->string('diag_text',250)->nullable();// 
        //         $table->string('pt_subtype',4)->nullable();// 
        //         $table->char('main_dep',3)->nullable();// 
        //         $table->integer('main_dep_queue',11)->nullable();// 

        //         $table->date('finance_summary_date')->nullable();// 
        //         $table->char('visit_type',1)->nullable();// 
        //         $table->char('node_id',1)->nullable();// 
        //         $table->integer('contract_id',11)->nullable();// 
        //         $table->char('waiting',1)->nullable();// 
        //         $table->string('rfri_icd10',6)->nullable();// 
        //         $table->integer('o_refer_number',11)->nullable();// 
        //         $table->char('has_insurance',1)->nullable();// 
        //         // $table->string('diag_text',250)->nullable();// 
        //         // $table->string('diag_text',250)->nullable();// 
        //         // $table->string('diag_text',250)->nullable();// 
        //         // $table->string('diag_text',250)->nullable();// 
        //         // $table->string('diag_text',250)->nullable();// 
        //         // $table->string('diag_text',250)->nullable();// 
        //         // $table->string('diag_text',250)->nullable();// 
        //         // $table->string('diag_text',250)->nullable();// 
        //         // $table->string('diag_text',250)->nullable();// 
        //         // $table->string('diag_text',250)->nullable();// 
        //         // $table->string('diag_text',250)->nullable();// 
        //         // $table->string('diag_text',250)->nullable();// 
        //         // $table->string('diag_text',250)->nullable();// 
        //         // $table->string('diag_text',250)->nullable();// 
        //         // $table->string('diag_text',250)->nullable();// 
        //         // $table->string('diag_text',250)->nullable();// 
        //         // $table->string('diag_text',250)->nullable();// 
        //         // $table->string('diag_text',250)->nullable();// 
        //         // $table->string('diag_text',250)->nullable();// 
        //         // $table->string('diag_text',250)->nullable();// 
        //         // $table->string('diag_text',250)->nullable();// 
        //         // $table->string('diag_text',250)->nullable();// 

               
        //         $table->char('hos_guid',38)->nullable();// 
        //         $table->string('hos_guid_ext',64)->nullable();// 
        //     }); 
            
        // }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('a_ovst');
    }
};
