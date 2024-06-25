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
        if (!Schema::hasTable('d_iop'))
        {
            Schema::connection('mysql')->create('d_iop', function (Blueprint $table) {
                $table->bigIncrements('d_iop_id'); 

                $table->string('AN',length: 15)->nullable();// 
                $table->string('OPER',length: 7)->nullable();// 
                $table->string('OPTYPE',length: 1)->nullable(); // 
                $table->string('DROPID',length: 6)->nullable(); //  
                $table->date('DATEIN')->nullable();// 
                $table->string('TIMEIN',length: 4)->nullable();//  
                $table->date('DATEOUT')->nullable();// 
                $table->string('TIMEOUT',length: 4)->nullable();// 

                $table->string('d_anaconda_id')->nullable(); // 
                $table->string('user_id')->nullable(); //   
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
        Schema::dropIfExists('d_iop');
    }
};
