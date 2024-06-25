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
        if (!Schema::hasTable('stm_import'))
        {
            Schema::connection('mysql7')->create('stm_import', function (Blueprint $table) {
                $table->bigIncrements('stm_import_id'); 
                $table->string('stm_head_id',100)->nullable();//
                $table->string('vn')->nullable();//
                $table->string('hreg')->nullable();//         
                $table->string('hn')->nullable();//
                $table->string('name')->nullable();// 
                
                $table->string('pid')->nullable();//วันที่
                $table->string('wkno')->nullable();//  
                $table->string('hds')->nullable();// 
                $table->string('quota')->nullable();// 
                
                $table->string('hdcharge')->nullable();// 
                $table->string('payable')->nullable();// 
                $table->string('outstanding')->nullable();//

                $table->string('effHDs')->nullable();// 
                $table->string('effHCT')->nullable();// 
                $table->string('epoPay')->nullable();// 
                $table->string('epoAdm')->nullable();// 

                $table->string('hcode')->nullable();// 
                $table->string('station')->nullable();// 
             
                $table->string('invno')->nullable();// 
                $table->string('dttran')->nullable();// 
                $table->string('hdrate')->nullable();// 
                $table->string('tbill_hdcharge')->nullable();//
                $table->string('amount')->nullable();// 
                $table->string('paid')->nullable();// 
                $table->string('rid')->nullable();// 
                $table->string('accp')->nullable();//  
                 
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
        Schema::dropIfExists('stm_import');
    }
};
