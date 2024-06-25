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
        if (!Schema::hasTable('acc_imc_an'))
        {
            Schema::connection('mysql')->create('acc_imc_an', function (Blueprint $table) { 
                $table->bigIncrements('acc_imc_an_id');//  
                $table->string('vn')->nullable();//   
                $table->string('an')->nullable();//  
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
        Schema::dropIfExists('acc_imc_an');
    }
};
