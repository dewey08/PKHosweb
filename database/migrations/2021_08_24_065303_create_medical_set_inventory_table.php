<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalSetInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('medical_set_inventory')){
            Schema::create('medical_set_inventory', function (Blueprint $table) {
                $table->id('SETINVEN_ID');
                $table->integer('INVEN_ID');
                $table->string('SETINVEN_NAME');
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
        Schema::dropIfExists('medical_set_inventory');
    }
}
