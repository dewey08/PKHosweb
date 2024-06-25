<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformcomSystemtypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('informcom_systemtype')) {

        Schema::create('informcom_systemtype', function (Blueprint $table) {
            
                $table->increments("INFORMCOM_ST_ID",11);
                $table->String("INFORMCOM_ST_NAME",255)->nullable();
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
        Schema::dropIfExists('informcom_systemtype');
    }
}
