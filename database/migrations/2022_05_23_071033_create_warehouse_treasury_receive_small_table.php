<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseTreasuryReceiveSmallTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('warehouse_treasury_receive_small')){ 
                Schema::create('warehouse_treasury_receive_small', function (Blueprint $table) {
                    $table->increments("TREASURY_RECEIVE_SMALL_ID",11);
                    $table->integer("TREASURY_RECEIVE_ID")->nullable(); 
                    $table->String("TREASURY_RECEIVE_SMALL_NAME",255)->nullable(); 
                    $table->integer("TREASURY_RECEIVE_SMALL_TYPE")->nullable(); 

                    $table->String("TREASURY_RECEIVE_SMALL_UNIT",255)->nullable(); 
                    $table->String("TREASURY_RECEIVE_SMALL_AMOUNT",255)->nullable(); 
                    $table->String("TREASURY_RECEIVE_SMALL_PICE_UNIT",255)->nullable(); 
                    $table->String("TREASURY_RECEIVE_SMALL_VALUE",255)->nullable(); 
                    $table->String("TREASURY_RECEIVE_SMALL_LOT",255)->nullable();
                     
                    $table->String("TREASURY_ID",255)->nullable(); 
                    $table->integer("WAREHOUSE_REQUEST_SMALL_ID")->nullable();

                    $table->String("TREASURT_PAY_ID",255)->nullable(); 
                    $table->integer("TREASURY_RECEIVE_SMALLHOS_ID")->nullable();

                    $table->date("TREASURY_RECEIVE_SMALL_GEN_DATE")->nullable(); 
                    $table->date("TREASURY_RECEIVE_SMALL_EXP_DATE")->nullable();
                    
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
        Schema::dropIfExists('warehouse_treasury_receive_small');
    }
}
