<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseTreasuryPaySmallTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('warehouse_treasury_pay_small')){ 
            Schema::create('warehouse_treasury_pay_small', function (Blueprint $table) {
           

                $table->increments("TREASURT_PAY_SMALL_ID",11);
                $table->String("TREASURT_PAY_SMALL_CODE",255)->nullable(); 
                $table->date("TREASURT_PAY_SMALL_DATE")->nullable(); 
                $table->String("TREASURT_PAY_SMALL_COMMENT",255)->nullable(); 
                $table->integer("TREASURT_PAY_SMALL_SAVE_HR_ID")->nullable(); 
                $table->String("TREASURT_PAY_SMALL_SAVE_HR_NAME",255)->nullable(); 
                $table->integer("TREASURT_PAY_SMALL_REQUEST_HR_ID")->nullable(); 
                $table->String("TREASURT_PAY_SMALL_REQUEST_HR_NAME",255)->nullable(); 
                $table->String("TREASURT_PAY_SMALL_NAME",255)->nullable(); 
                $table->integer("TREASURT_PAY_SMALL_REQUEST_SUB_SUB_ID")->nullable();           
                $table->String("REPAIR_ID",255)->nullable();           
                $table->String("TREASURT_PAY_SMALL_REQUEST_OBJ",255)->nullable();           
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
        Schema::dropIfExists('warehouse_treasury_pay_small');
    }
}
