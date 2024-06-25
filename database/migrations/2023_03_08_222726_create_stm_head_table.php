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
        if (!Schema::hasTable('stm_head'))
        {
            Schema::connection('mysql7')->create('stm_head', function (Blueprint $table) {
                $table->bigIncrements('stm_head_id'); 
                $table->string('stmAccountID',100)->nullable();//
                $table->string('hcode')->nullable();//         
                $table->string('hname')->nullable();//
                $table->string('AccPeriod')->nullable();// 
                
                $table->dastringte('dateStart')->nullable();//วันที่
                $table->string('dateEnd')->nullable();//  
                $table->string('dateData')->nullable();// 
                $table->string('dateIssue')->nullable();// 
                
                $table->string('STMdoc')->nullable();// 
                $table->string('acount')->nullable();// 
                $table->string('amount')->nullable();// 
                $table->string('thamount')->nullable();// 
                $table->string('STMdat')->nullable();// 
                $table->string('HDBills')->nullable();// 
                $table->string('Remarks')->nullable();// 
                $table->string('config')->nullable();// 
                 
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
        Schema::dropIfExists('stm_head');
    }
};
