<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseFunctionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {       
        if (!Schema::hasTable('warehouse_function'))
        {
                Schema::create('warehouse_function', function (Blueprint $table) {
                    $table->id("WAREHOUSEFORM_ID",11);
                    $table->String("WAREHOUSEFORM_CODE",255)->nullable(); 
                    $table->String("WAREHOUSEFORM_NAME",255)->nullable(); 
                    $table->enum('WAREHOUSEFORM_STATUS', ['True', 'False']);   
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
        Schema::dropIfExists('warehouse_function');
    }
}
