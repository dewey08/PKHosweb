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
        if (!Schema::hasTable('acc_stm_lgoti_excel'))
        {
            Schema::connection('mysql')->create('acc_stm_lgoti_excel', function (Blueprint $table) {
                $table->bigIncrements('acc_stm_lgoti_excel_id'); 
                $table->string('repno',100)->nullable();//   
                $table->string('hn')->nullable();//    
                $table->string('cid')->nullable();//
                $table->string('ptname')->nullable();//ชื่อ-สกุล 
                $table->string('type')->nullable();// 
                $table->date('vstdate')->nullable();//วันที่เข้ารับบริการ   
                $table->string('pay_amount')->nullable();//   
                $table->enum('active', ['REP','APPROVE','CANCEL','FINISH'])->default('APPROVE')->nullable(); 
                $table->string('STMDoc',255)->nullable();// 
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
        Schema::dropIfExists('acc_stm_lgoti_excel');
    }
};
