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
        if (!Schema::hasTable('acc_stm_ucs_excel'))
        {
            Schema::connection('mysql')->create('acc_stm_ucs_excel', function (Blueprint $table) {
                $table->bigIncrements('acc_stm_ucs_excel_id');
                $table->string('rep',100)->nullable();//  rep
                $table->string('repno',100)->nullable();//  rep
                $table->string('tranid')->nullable();//  เลขที่หนังสือ
                $table->string('hn')->nullable();//
                $table->string('an')->nullable();//
                $table->string('cid')->nullable();//
                $table->string('fullname')->nullable();//ชื่อ-สกุล
                $table->string('vstdate')->nullable();//วันที่เข้ารับบริการ
                $table->string('dchdate')->nullable();//วันที่จำหน่าย
                $table->string('maininscl')->nullable();//
                $table->string('projectcode')->nullable();//
                $table->string('debit')->nullable();//เรียกเก็บ
                $table->string('debit_prb')->nullable();//พรบ.
                $table->string('adjrw')->nullable();//adjrw
                $table->string('ps1')->nullable();//ล่าช้า (PS)
                $table->string('ps2')->nullable();//ล่าช้า (PS)
                $table->string('ccuf')->nullable();//ccuf
                $table->string('adjrw2')->nullable();//AdjRW2
                $table->string('pay_money', 255)->nullable();//อัตราจ่าย
                $table->string('pay_slip', 255)->nullable();//เงินเดือน
                $table->string('pay_after', 255)->nullable();//จ่ายชดเชยหลังหัก พรบ.และเงินเดือน
                $table->string('op', 255)->nullable();//OP

                $table->string('ip_pay1',255)->nullable();//
                $table->string('ip_paytrue', 255)->nullable();//
                $table->string('hc', 255)->nullable();//
                $table->string('hc_drug', 255)->nullable();//
                $table->string('ae', 255)->nullable();//
                $table->string('ae_drug', 255)->nullable();//
                $table->string('inst', 255)->nullable();//
                $table->string('dmis_money1', 255)->nullable();//
                $table->string('dmis_money2', 255)->nullable();//
                $table->string('dmis_drug', 255)->nullable();//
                $table->string('palliative_care', 255)->nullable();//Palliative care
                $table->string('dmishd', 255)->nullable();//DMISHD
                $table->string('pp', 255)->nullable();//PP
                $table->string('fs', 255)->nullable();//FS
                $table->string('opbkk', 255)->nullable();//OPBKK
                $table->string('total_approve', 255)->nullable();//ยอดชดเชยทั้งสิ้น
                $table->string('va',255)->nullable();//va
                $table->string('covid')->nullable();//covid
                $table->date('date_save')->nullable();//
                $table->string('STMdoc')->nullable();//

                $table->enum('active', ['REP','APPROVE','CANCEL','FINISH','PULL'])->default('PULL')->nullable();
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
        Schema::dropIfExists('acc_stm_ucs_excel');
    }
};
