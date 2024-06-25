<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfomrepairFunctioncomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      
        if(!Schema::hasTable('infomrepair_functioncom')){
            Schema::create('infomrepair_functioncom', function (Blueprint $table) {
                $table->id("FUNCT_REPCOM_ID",11); 
                $table->String("FUNCT_REPCOM_CODE",255)->nullable();              
                $table->String("FUNCT_REPCOM_NAME",255)->nullable(); 
                $table->enum('FUNCT_REPCOM_STATUS', ['True', 'False'])->default('True');  
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
        Schema::dropIfExists('infomrepair_functioncom');
    }
}
