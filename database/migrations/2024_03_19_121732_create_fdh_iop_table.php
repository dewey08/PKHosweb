<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    { 
        if (!Schema::hasTable('fdh_iop'))
        {
            Schema::connection('mysql')->create('fdh_iop', function (Blueprint $table) {
                $table->bigIncrements('fdh_iop_id'); 

                $table->string('AN',length: 15)->nullable();// 
                $table->string('OPER',length: 7)->nullable();// 
                $table->string('OPTYPE',length: 1)->nullable(); // 
                $table->string('DROPID',length: 6)->nullable(); //  
                $table->string('DATEIN',length: 8)->nullable();// 
                $table->string('TIMEIN',length: 4)->nullable();//  
                $table->string('DATEOUT',length: 8)->nullable();// 
                $table->string('TIMEOUT',length: 4)->nullable();// 

                $table->string('d_anaconda_id')->nullable(); // 
                $table->string('user_id')->nullable(); //   
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fdh_iop');
    }
};
