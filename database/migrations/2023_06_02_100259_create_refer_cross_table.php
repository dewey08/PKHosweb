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
        if (!Schema::hasTable('refer_cross'))
        {
            Schema::create('refer_cross', function (Blueprint $table) {
                $table->bigIncrements('refer_cross_id');   
                $table->string('vn')->nullable();// 
                $table->string('an')->nullable();// 
                $table->string('hn')->nullable();// 
                $table->string('cid')->nullable();// 
                $table->date('vstdate')->nullable();//   
                $table->time('vsttime')->nullable();// 
                $table->string('ptname')->nullable();//  
                $table->string('pttype')->nullable();// 
                $table->string('hospcode')->nullable();// 
                $table->string('hospmain')->nullable();// 
                $table->string('icd10')->nullable();//
                $table->string('pdx')->nullable();// 
                $table->string('dx0')->nullable();// 
                $table->string('dx1')->nullable();// 
                $table->string('income')->nullable();// 
                $table->string('refer')->nullable();// 
                $table->string('Total')->nullable();// 
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
        Schema::dropIfExists('refer_cross');
    }
};
