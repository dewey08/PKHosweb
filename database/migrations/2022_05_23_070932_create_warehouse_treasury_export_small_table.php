<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseTreasuryExportSmallTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('warehouse_treasury_export_small')){ 

                Schema::create('warehouse_treasury_export_small', function (Blueprint $table) {
                    $table->increments("TREASURY_EXPORT_SMALL_ID",11);
                    $table->integer("TREASURY_EXPORT_ID")->nullable(); 
                    $table->String("TREASURY_EXPORT_SMALL_NAME",255)->nullable(); 
                    $table->integer("TREASURY_EXPORT_SMALL_TYPE")->nullable(); 

                    $table->String("TREASURY_EXPORT_SMALL_UNIT",255)->nullable(); 
                    $table->String("TREASURY_EXPORT_SMALL_AMOUNT",255)->nullable(); 
                    $table->String("TREASURY_EXPORT_SMALL_PICE_UNIT",255)->nullable(); 
                    $table->String("TREASURY_EXPORT_SMALL_VALUE",255)->nullable(); 
                    $table->String("TREASURY_EXPORT_SMALL_LOT",255)->nullable();

                    $table->String("TREASURY_ID",255)->nullable(); 
                    $table->integer("WAREHOUSE_REQUEST_SMALL_ID")->nullable();
                    
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
        Schema::dropIfExists('warehouse_treasury_export_small');
    }
}
