<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseTreasurySmallTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if(!Schema::hasTable('warehouse_treasury_small')){ 
                Schema::create('warehouse_treasury_small', function (Blueprint $table) {

                    $table->increments("TREASURY_SMALL_ID",11);
                    $table->String("TREASURY_SMALL_CODE",255)->nullable(); 
                    $table->String("TREASURY_SMALL_NAME",255)->nullable(); 
                    $table->integer("TREASURY_SMALL_TYPE")->nullable();  
                    $table->String("TREASURY_SMALL_TYPE_NAME",255)->nullable(); 
                    $table->String("TREASURY_SMALL_UNIT",255)->nullable(); 
                    $table->String("TREASURY_SMALL_SUP_ID",255)->nullable();           
                    
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
        Schema::dropIfExists('warehouse_treasury_small');
    }
}
