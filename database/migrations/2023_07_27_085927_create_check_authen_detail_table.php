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
      
        if (!Schema::connection('mysql')->hasTable('check_authen_detail'))
        {
            Schema::connection('mysql')->create('check_authen_detail', function (Blueprint $table) {
                $table->bigIncrements('check_authen_detail_id'); 
                $table->string('vn')->nullable();//
                $table->string('an')->nullable();// 
                $table->string('hn')->nullable();//   
                $table->string('cid')->nullable();//  
                $table->date('vstdate')->nullable();//  
                $table->string('ptname')->nullable();//  
                $table->string('staff')->nullable(); //                    
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
        Schema::dropIfExists('check_authen_detail');
    }
};
