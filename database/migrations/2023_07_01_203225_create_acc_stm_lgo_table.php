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
        if (!Schema::hasTable('acc_stm_lgo'))
        {
            Schema::connection('mysql')->create('acc_stm_lgo', function (Blueprint $table) {
                $table->bigIncrements('acc_stm_lgo_id'); 
                $table->string('rep_a',100)->nullable();//   
                $table->string('no_b')->nullable();// 
                $table->string('tranid_c')->nullable();// 
                $table->string('hn_d')->nullable();//   
                $table->string('an_e')->nullable();//  
                $table->string('cid_f')->nullable();//
                $table->string('fullname_g')->nullable();//ชื่อ-สกุล 
                $table->string('type_h')->nullable();//ประเภทผู้ป่วย
                $table->date('vstdate_i')->nullable();//วันที่เข้ารับบริการ  
                $table->date('dchdate_j')->nullable();// 
                $table->string('price1_k')->nullable();// 
                $table->string('pp_spsch_l')->nullable();//   
                $table->string('errorcode_m')->nullable();//  
                $table->string('kongtoon_n',255)->nullable();//     
                $table->string('typeservice_o')->nullable();//  
                $table->string('refer_p')->nullable();//  
                $table->string('pttype_have_q')->nullable();//    
                $table->string('pttype_true_r')->nullable();// 
                $table->string('mian_pttype_s')->nullable();// 
                $table->string('secon_pttype_t')->nullable();// 
                $table->string('href_u')->nullable();// 
                $table->string('HCODE_v')->nullable();// 
                $table->string('prov1_w')->nullable();//  
                $table->string('code_dep_x')->nullable();//  
                $table->string('name_dep_y')->nullable();//  
                $table->string('proj_z')->nullable();// 
                $table->string('pa_aa')->nullable();// 
                $table->string('drg_ab')->nullable();// 
                $table->string('rw_ac')->nullable();// 
                $table->string('income_ad')->nullable();// 
                $table->string('pp_gep_ae')->nullable();// 
                $table->string('claim_true_af')->nullable();// 
                $table->string('claim_false_ag')->nullable();//                 
                $table->string('cash_money_ah')->nullable();//
                $table->string('pay_ai')->nullable();//
                $table->string('ps_aj')->nullable();//
                $table->string('ps_percent_ak')->nullable();//
                $table->string('ccuf_al')->nullable();//
                $table->string('AdjRW_am')->nullable();//
                $table->string('plb_an')->nullable();//
                $table->string('IPLG_ao')->nullable();//
                $table->string('OPLG_ap')->nullable();//
                $table->string('PALG_aq')->nullable();//
                $table->string('INSTLG_ar')->nullable();//
                $table->string('OTLG_as')->nullable();//
                $table->string('PP_at')->nullable();//
                $table->string('DRUG_au')->nullable();//
                $table->string('IPLG2')->nullable();//
                $table->string('OPLG2')->nullable();//
                $table->string('PALG2')->nullable();//
                $table->string('INSTLG2')->nullable();//
                $table->string('OTLG2')->nullable();//
                $table->string('ORS')->nullable();//
                $table->string('VA')->nullable();//
                $table->string('STMdoc')->nullable();//  
                $table->enum('active', ['REP','APPROVE','CANCEL','FINISH'])->default('REP')->nullable(); 
                $table->timestamp(column:'created_at')->useCurrent();
                $table->timestamp(column:'updated_at')->nullable();
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
        Schema::dropIfExists('acc_stm_lgo');
    }
};
