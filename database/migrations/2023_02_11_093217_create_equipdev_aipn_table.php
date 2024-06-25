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
        if (!Schema::hasTable('equipdev_aipn'))
        {
            Schema::connection('mysql7')->create('equipdev_aipn', function (Blueprint $table) {
                $table->bigIncrements('equipdev_aipn_id');
                $table->string('billgrcs',2)->nullable();// 
                $table->string('bcode',200)->nullable();//  
                $table->string('cscode',8)->nullable();// 
                $table->string('unit',100)->nullable();// 
                $table->double('rate', 15, 2)->nullable();
                
                $table->string('revclass',3)->nullable();// 
                $table->string('revrate',3)->nullable();// 
                $table->string('desc',200)->nullable();// 

                $table->date('daterev')->nullable();// 
                $table->date('dateeff')->nullable();// 
                $table->date('dateexp')->nullable();// 
                $table->date('lastupd')->nullable();// 

                $table->string('active',2)->nullable();// 
                $table->string('dxcond',100)->nullable();// 
                $table->string('note',200)->nullable();//                         
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
        Schema::dropIfExists('equipdev_aipn');
    }
};
