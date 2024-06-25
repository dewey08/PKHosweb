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
        if (!Schema::hasTable('d_ofc_rep'))
        {
            Schema::connection('mysql')->create('d_ofc_rep', function (Blueprint $table) {
                $table->bigIncrements('d_ofc_rep_id'); 
                $table->string('rep_a',100)->nullable();//   
                $table->string('no_b')->nullable();// 
                $table->string('tranid_c')->nullable();// 
                $table->string('hn_d')->nullable();//   
                $table->string('an_e')->nullable();//  
                $table->string('pid_f')->nullable();//
                $table->string('ptname_g')->nullable();//ชื่อ-สกุล 
                $table->string('type_h')->nullable();//ประเภทผู้ป่วย
                $table->date('vstdate_i')->nullable();//วันที่เข้ารับบริการ  
                $table->date('dchdate_j')->nullable();//   วันจำหน่าย
                $table->string('price1_k')->nullable();//     ค่ารักษา
                $table->string('pp_spsch_l')->nullable();//   PP (รับจาก สปสช.)
                $table->string('errorcode_m')->nullable();//  Error Code
                $table->string('kongtoon_n',255)->nullable();//  กองทุน
                $table->string('typeservice_o')->nullable();//   ประเภทบริการ
                $table->string('refer_p')->nullable();//         การรับส่งต่อ
                $table->string('pttype_have_q')->nullable();//    การมีสิทธิ
                $table->string('pttype_true_r')->nullable();//    การใช้สิทธิ 
                $table->string('mian_pttype_s')->nullable();//    สิทธิหลัก
                $table->string('secon_pttype_t')->nullable();//    สิทธิรอง
                $table->string('href_u')->nullable();//            HREF
                $table->string('HCODE_v')->nullable();//           HCODE
                $table->string('prov1_w')->nullable();//           PROV1
                $table->string('code_dep_x')->nullable();//        รหัสหน่วยงาน
                $table->string('name_dep_y')->nullable();//        ชื่อหน่วยงาน
                $table->string('proj_z')->nullable();//            PROJ
                $table->string('pa_aa')->nullable();//             PA
                $table->string('drg_ab')->nullable();//             DRG 
                $table->string('rw_ac')->nullable();//             RW
                $table->string('income_ad')->nullable();//          ค่ารักษา
                $table->string('pp_gep_ae')->nullable();//            PP
                $table->string('claim_true_af')->nullable();//       เบิกได้
                $table->string('claim_false_ag')->nullable();//       เบิกไม่ได้            
                $table->string('cash_money_ah')->nullable();//      ชำระเอง
                $table->string('pay_ai')->nullable();//          อัตราจ่าย
                $table->string('ps_aj')->nullable();//           ล่าช้า (PS)
                $table->string('ps_percent_ak')->nullable();//    ล่าช้า (PS) เปอร์เซ็นต์
                $table->string('ccuf_al')->nullable();//            CCUF
                $table->string('AdjRW_am')->nullable();//           AdjRW
                $table->string('plb_an')->nullable();//              พรบ.
               
                $table->string('IPCS_ao')->nullable();//                IPCS
                $table->string('IPCS_ORS_ap')->nullable();//               IPCS_ORS
                $table->string('OPCS_aq')->nullable();//             OPCS
                $table->string('PACS_ar')->nullable();//          PACS
                $table->string('INSTCS_as')->nullable();//          INSTCS
                $table->string('OTCS_at')->nullable();//              OTCS
                $table->string('PP_au')->nullable();//           PP
                $table->string('DRUG_av')->nullable();//           DRUG
                
                $table->string('IPCS_aw')->nullable();//          IPCS
                $table->string('OPCS_AX')->nullable();//        OPCS
                $table->string('PACS_ay')->nullable();//        PACS
                $table->string('INSTCS_az')->nullable();//          INSTCS
                $table->string('OTCS_ba')->nullable();//           OTCS
                $table->string('ORS_bb')->nullable();//           ORS
                $table->string('VA_bc')->nullable();//
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
        Schema::dropIfExists('d_ofc_rep');
    }
};
