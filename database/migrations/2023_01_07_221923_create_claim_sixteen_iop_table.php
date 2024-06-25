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
        if (!Schema::hasTable('claim_sixteen_iop'))
        {
            Schema::create('claim_sixteen_iop', function (Blueprint $table) {
                $table->bigIncrements('claim_sixteen_iop_id');

                $table->string('HN')->nullable();// 
                $table->string('AN')->nullable();// 

                $table->date('DATEIN')->nullable();// 
                $table->string('TIMEIN')->nullable();//  
                $table->date('DATEOUT')->nullable();// 
                $table->string('TIMEOUT')->nullable();//  

                $table->string('OPER')->nullable();//  
                $table->string('OPTYPE')->nullable(); //   
                $table->string('DROPID')->nullable(); //  
 
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
        Schema::dropIfExists('claim_sixteen_iop');
    }
};
