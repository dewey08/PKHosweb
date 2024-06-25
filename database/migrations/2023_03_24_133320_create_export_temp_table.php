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
        if (!Schema::hasTable('export_temp'))
        {
            Schema::connection('mysql7')->create('export_temp', function (Blueprint $table) { 
                $table->bigIncrements('vn');//  
                $table->string('an')->nullable();//   
                $table->string('hn')->nullable();// 
                $table->string('cid')->nullable();// 
                $table->string('fullname')->nullable();//    
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
        Schema::dropIfExists('export_temp');
    }
};
