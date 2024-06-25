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
        if (!Schema::hasTable('d_ssop_main'))
        {
            Schema::connection('mysql')->create('d_ssop_main', function (Blueprint $table) { 
                $table->bigIncrements('d_ssop_main_id');//  
                $table->string('vn')->nullable();//   
                $table->string('an')->nullable();//  
                $table->string('hn')->nullable();//  
                $table->string('pttype')->nullable();// 
                $table->date('vstdate')->nullable();//  
                $table->string('price_ssop')->nullable();// 
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
        Schema::dropIfExists('d_ssop_main');
    }
};
