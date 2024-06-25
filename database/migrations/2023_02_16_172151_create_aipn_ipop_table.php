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
        if (!Schema::hasTable('aipn_ipop'))
        {
            Schema::connection('mysql')->create('aipn_ipop', function (Blueprint $table) {
                $table->bigIncrements('aipn_ipop_id'); 
                $table->string('an')->nullable();//   
                $table->string('sequence')->nullable();//   
                $table->string('CodeSys')->nullable();//  
                $table->string('Code')->nullable();//  
                $table->string('Procterm')->nullable();//  
                $table->string('DR')->nullable();// 
                $table->string('DateIn')->nullable();// 
                $table->string('DateOut')->nullable();//  
                $table->string('Location')->nullable();// 
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
        Schema::dropIfExists('aipn_ipop');
    }
};
