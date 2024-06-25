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
        if (!Schema::hasTable('acc_setpang_type'))
        {
            Schema::connection('mysql')->create('acc_setpang_type', function (Blueprint $table) { 
                $table->bigIncrements('acc_setpang_type_id');//                 
                $table->string('acc_setpang_id')->nullable();//  
                $table->string('pang')->nullable();//  
                $table->string('pttype')->nullable();//    
                $table->string('hipdata_code')->nullable();//   
                $table->string('icode')->nullable();//
                $table->string('no_icode')->nullable();//
                $table->string('hospmain')->nullable();//
                $table->string('icd9')->nullable();//
                $table->string('opdipd')->nullable();//
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
        Schema::dropIfExists('acc_setpang_type');
    }
};
