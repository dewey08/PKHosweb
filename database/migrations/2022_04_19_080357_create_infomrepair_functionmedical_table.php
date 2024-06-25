<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfomrepairFunctionmedicalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {       
        if(!Schema::hasTable('infomrepair_functionmedical')){
            Schema::create('infomrepair_functionmedical', function (Blueprint $table) {
                $table->id("FUNCT_REPMEDICAL_ID",11); 
                $table->String("FUNCT_REPMEDICAL_CODE",255)->nullable();              
                $table->String("FUNCT_REPMEDICAL_NAME",255)->nullable(); 
                $table->enum('FUNCT_REPMEDICAL_STATUS', ['True', 'False'])->default('True');  
                $table->dateTime('updated_at');
                $table->dateTime('created_at');
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
        Schema::dropIfExists('infomrepair_functionmedical');
    }
}
