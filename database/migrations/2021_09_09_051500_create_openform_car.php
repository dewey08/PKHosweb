<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpenformCar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {      
        if (!Schema::hasTable('openform_car'))
        {
                Schema::create('openform_car', function (Blueprint $table) {
                    $table->id("OPENFORMCAR_ID",11);
                    $table->String("OPENFORMCAR_CODE",255)->nullable(); 
                    $table->String("OPENFORMCAR_NAME",255)->nullable(); 
                    $table->enum('OPENFORMCAR_STATUS', ['True', 'False']);   
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
        Schema::dropIfExists('openform_car');
    }
}
