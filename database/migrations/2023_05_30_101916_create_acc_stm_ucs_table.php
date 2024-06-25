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
        if (!Schema::hasTable('acc_stm_ucs'))
        {
            Schema::connection('mysql')->create('acc_stm_ucs', function (Blueprint $table) {
                $table->bigIncrements('acc_stm_ucs_id');  
                $table->string('rep',100)->nullable();//  rep    
                $table->string('repno',100)->nullable();//  rep    
                $table->string('tranid')->nullable();//  เลขที่หนังสือ            
                $table->string('hn')->nullable();//    
                $table->string('an')->nullable();//  
                $table->string('cid')->nullable();//
                $table->string('fullname')->nullable();//ชื่อ-สกุล             
                $table->dateTime('vstdate')->nullable();//วันที่เข้ารับบริการ
                $table->dateTime('dchdate')->nullable();//วันที่จำหน่าย
                $table->string('maininscl')->nullable();//
                $table->string('projectcode')->nullable();//
                $table->string('debit')->nullable();//เรียกเก็บ
                $table->string('debit_prb')->nullable();//พรบ.
                $table->string('adjrw')->nullable();//adjrw
                $table->string('ps1')->nullable();//ล่าช้า (PS)
                $table->string('ps2')->nullable();//ล่าช้า (PS)
                $table->string('ccuf')->nullable();//ccuf
                $table->string('adjrw2')->nullable();//AdjRW2             
                $table->string('pay_money')->nullable();//อัตราจ่าย
                $table->string('pay_slip')->nullable();//เงินเดือน
                $table->string('pay_after')->nullable();//จ่ายชดเชยหลังหัก พรบ.และเงินเดือน
                $table->string('op')->nullable();//OP

                $table->string('ip_pay1')->nullable();//
                $table->string('ip_paytrue')->nullable();//
                $table->string('hc')->nullable();//
                $table->string('hc_drug')->nullable();//
                $table->string('ae')->nullable();//
                $table->string('ae_drug')->nullable();//
                $table->string('inst')->nullable();// 
                $table->string('dmis_money1')->nullable();//
                $table->string('dmis_money2')->nullable();//
                $table->string('dmis_drug')->nullable();// 
                $table->string('palliative_care')->nullable();//Palliative care
                $table->string('dmishd')->nullable();//DMISHD 
                $table->string('pp')->nullable();//PP                
                $table->string('fs')->nullable();//FS
                $table->string('opbkk')->nullable();//OPBKK
                $table->string('total_approve')->nullable();//ยอดชดเชยทั้งสิ้น
                $table->string('va')->nullable();//va
                $table->string('covid')->nullable();//covid 
                $table->date('date_save')->nullable();// 
                $table->string('STMdoc')->nullable();//    
                
                $table->enum('active', ['REP','APPROVE','CANCEL','FINISH','PULL'])->default('PULL')->nullable(); 
                $table->timestamps();
            });
        }
    }
 
    public function down()
    {
        Schema::dropIfExists('acc_stm_ucs');
    }
};
