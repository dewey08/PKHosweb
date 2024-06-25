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
        if (!Schema::hasTable('fs_eclaim'))
        {
            Schema::connection('mysql7')->create('fs_eclaim', function (Blueprint $table) {
                $table->bigIncrements('fs_eclaim_id'); 
                $table->string('num')->nullable();//
                $table->string('billcode')->nullable();//  
                $table->string('dname')->nullable();// 
                $table->string('unit')->nullable();// 
                $table->string('income')->nullable();// 
                $table->string('pay_rate')->nullable();// 
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
        Schema::dropIfExists('fs_eclaim');
    }
};
