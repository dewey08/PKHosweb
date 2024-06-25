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
        if (!Schema::hasTable('d_aipn_main'))
        {
            Schema::connection('mysql')->create('d_aipn_main', function (Blueprint $table) { 
                $table->bigIncrements('d_aipn_main_id');//  
                $table->string('vn')->nullable();//   
                $table->string('an')->nullable();//  
                $table->string('hn')->nullable();//   
                $table->string('dchdate')->nullable();// 
                $table->string('debit')->nullable();// 
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
        Schema::dropIfExists('d_aipn_main');
    }
};
