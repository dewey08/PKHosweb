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
        if (!Schema::hasTable('claim_sixteen_ipd'))
        {
            Schema::create('claim_sixteen_ipd', function (Blueprint $table) {
                $table->bigIncrements('claim_sixteen_ipd_id');

                $table->string('HN')->nullable();// 
                $table->string('AN')->nullable();// 

                $table->date('DATEADM')->nullable();// 
                $table->string('TIMEADM')->nullable();//  
                $table->date('DATEDSC')->nullable();// 
                $table->string('TIMEDSC')->nullable();//  

                $table->string('DISCHS')->nullable();//  
                $table->string('DISCHT')->nullable(); //   
                $table->string('WARDDSC')->nullable(); //  
                $table->string('DEPT')->nullable(); // 
                $table->string('ADM_W')->nullable(); // 
                $table->string('UUC')->nullable(); // 
                $table->string('SVCTYPE')->nullable(); // 
 
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
        Schema::dropIfExists('claim_sixteen_ipd');
    }
};
