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
        if (!Schema::hasTable('acc_set'))
        {
            Schema::create('acc_set', function (Blueprint $table) {
                $table->bigIncrements('acc_set_id');   
                $table->date('vstdate')->nullable();//   
                $table->string('vn')->nullable();//  
                $table->string('hn')->nullable();// 
                $table->string('an')->nullable();// 
                $table->string('ptname')->nullable();//
                $table->string('pttype')->nullable();//
                $table->string('income')->nullable();//
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
        Schema::dropIfExists('acc_set');
    }
};
