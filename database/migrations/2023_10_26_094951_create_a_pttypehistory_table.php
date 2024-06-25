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
        if (!Schema::hasTable('a_pttypehistory'))
        {
            Schema::connection('mysql')->create('a_pttypehistory', function (Blueprint $table) { 
                $table->string('hn',9)->nullable();//  pri 1
                $table->date('expiredate')->nullable();// 
                $table->string('hospmain',5)->nullable();//   
                $table->string('hospsub',5)->nullable();// 
                $table->string('pttype',10)->nullable();//   pri 2  +  pri3
                $table->string('pttypeno',50)->nullable();// 
                $table->date('begindate')->nullable();//  
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
        Schema::dropIfExists('a_pttypehistory');
    }
};
