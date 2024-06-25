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
        if (!Schema::hasTable('aipn_ipdx'))
        {
            Schema::connection('mysql')->create('aipn_ipdx', function (Blueprint $table) {
                $table->bigIncrements('aipn_ipdx_id'); 
                $table->string('an')->nullable();// 
                $table->string('sequence')->nullable();// รหัส
                $table->string('DxType')->nullable();//  
                $table->string('Dcode')->nullable();//  
                $table->string('CodeSys')->nullable();// 
                $table->string('DiagTerm')->nullable();// 
                $table->string('DR')->nullable();// 
                $table->string('datediag')->nullable();// 
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
        Schema::dropIfExists('aipn_ipdx');
    }
};
