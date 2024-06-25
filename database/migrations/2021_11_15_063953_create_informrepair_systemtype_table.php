<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformrepairSystemtypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('informrepair_systemtype')) {
            Schema::create('informrepair_systemtype', function (Blueprint $table) {
            
                $table->increments("INFORMRE_ST_ID",11);
                $table->String("INFORMRE_ST_NAME",255)->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->dateTime('created_at')->nullable();
           
           
            
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
        Schema::dropIfExists('informrepair_systemtype');
    }
}
