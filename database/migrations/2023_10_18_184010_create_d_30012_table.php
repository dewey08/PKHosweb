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
        if (!Schema::hasTable('d_30012'))
        {
            Schema::connection('mysql')->create('d_30012', function (Blueprint $table) { 
                $table->bigIncrements('d_30012_id');//  
                $table->string('vn')->nullable();//   
                $table->string('hn')->nullable();// 
                $table->string('icode')->nullable();//  
                $table->string('sum_price')->nullable();//   
                $table->string('preg_no')->nullable();// 
                $table->string('gaNOW')->nullable();// 
                $table->date('lmp')->nullable();// 
                $table->date('labor_date')->nullable();//  
                $table->date('anc_service_date')->nullable();//  
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
        Schema::dropIfExists('d_30012');
    }
};
