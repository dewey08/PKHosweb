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
        if (!Schema::hasTable('aipn_stm'))
        {
            Schema::connection('mysql')->create('aipn_stm', function (Blueprint $table) {
                $table->bigIncrements('aipn_stm_id');
                $table->string('rep_no')->nullable();// 
                $table->string('tran_id')->nullable();// 
                $table->date('rep_date')->nullable();// 
                $table->string('AN')->nullable();//  
                $table->string('VN')->nullable();//
                $table->string('HN')->nullable();//
                $table->string('pid')->nullable();//  
                $table->string('hipdata_code')->nullable();//  
                $table->string('pttype')->nullable();// 
                $table->date('vstdate')->nullable();// 
                $table->Time('vsttime')->nullable();// 
                $table->date('dchdate')->nullable();// 
                $table->Time('dchtime')->nullable();// 
                $table->string('icode')->nullable();// 
                $table->string('Descript')->nullable();// 
                $table->string('QTY')->nullable();//              
                $table->double('UnitPrice', 10, 2)->nullable();
                $table->double('ChargeAmt', 10, 4)->nullable();
                $table->double('rep_price', 10, 4)->nullable();
                $table->double('total_price', 10, 4)->nullable(); ////total_price = rep_price - ChargeAmt
                $table->double('Discount', 10, 4)->nullable(); 
                $table->string('ClaimSys')->nullable();// 
                $table->string('BillGrCS')->nullable();// 
                $table->string('CSCode')->nullable();// 
                $table->string('CodeSys')->nullable();// 
                $table->string('STDCode')->nullable();// 
                $table->string('ClaimCat')->nullable();// 
                $table->date('DateRev')->nullable();// 
                $table->double('ClaimUP', 10, 4)->nullable();
                $table->double('ClaimAmt', 10, 4)->nullable();     
                $table->enum('aipn_stm_active', ['PULL','CHECK','UPDATA','SEND','REP'])->default('PULL')->nullable();            
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
        Schema::dropIfExists('aipn_stm');
    }
};
