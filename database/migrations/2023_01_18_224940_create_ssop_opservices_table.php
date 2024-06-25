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
        if (!Schema::hasTable('ssop_opservices'))
        {
            Schema::connection('mysql')->create('ssop_opservices', function (Blueprint $table) {
                $table->bigIncrements('ssop_opservices_id');
                $table->string('Invno')->nullable();//   
                $table->string('SvID')->nullable();// 
                $table->string('Class')->nullable();// 
                $table->string('Hcode')->nullable();// 
                $table->string('HN')->nullable();// 
                $table->string('PID')->nullable();// 
                $table->string('CareAccount')->nullable();//  
                $table->string('TypeServ')->nullable();// 
                $table->string('TypeIn')->nullable();//  
                $table->string('TypeOut')->nullable();// 
                $table->string('DTAppoint')->nullable();// 
                $table->string('SvPID')->nullable();// 
                $table->string('Clinic')->nullable();// 
                $table->string('BegDT')->nullable();// 
                $table->string('EndDT')->nullable();// 
                $table->string('LcCode')->nullable();// 
                $table->string('CodeSet')->nullable();// 
                $table->string('STDCode')->nullable();// 
                $table->string('SvCharge')->nullable();// 
                $table->string('Completion')->nullable();// 
                $table->string('SvTxCode')->nullable();// 
                $table->string('ClaimCat')->nullable();//  
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
        Schema::dropIfExists('ssop_opservices');
    }
};
