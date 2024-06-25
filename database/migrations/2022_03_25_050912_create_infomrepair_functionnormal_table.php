<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfomrepairFunctionnormalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {      
        if(!Schema::hasTable('infomrepair_functionnormal')){
            Schema::create('infomrepair_functionnormal', function (Blueprint $table) {
                $table->id("FUNCT_REPNORMAL_ID",11); 
                $table->String("FUNCT_REPNORMAL_CODE",255)->nullable();              
                $table->String("FUNCT_REPNORMAL_NAME",255)->nullable(); 
                $table->enum('FUNCT_REPNORMAL_STATUS', ['True', 'False'])->default('True');  
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
        Schema::dropIfExists('infomrepair_functionnormal');
    }
}
