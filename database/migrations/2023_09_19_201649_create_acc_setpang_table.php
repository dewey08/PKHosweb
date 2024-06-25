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
        if (!Schema::hasTable('acc_setpang'))
        {
            Schema::connection('mysql')->create('acc_setpang', function (Blueprint $table) { 
                $table->bigIncrements('acc_setpang_id');//                 
                $table->string('pang')->nullable();//  
                $table->string('pangname')->nullable();//    
                $table->string('pttype')->nullable();// 
                $table->string('hipdata_code')->nullable();//   
                $table->string('icode')->nullable();//    
                $table->enum('active', ['TRUE','FALSE'])->default('TRUE')->nullable(); //สถานะ
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
        Schema::dropIfExists('acc_setpang');
    }
};
