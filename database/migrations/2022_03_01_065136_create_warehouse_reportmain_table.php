<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseReportmainTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('warehouse_reportmain')){
            Schema::create('warehouse_reportmain', function (Blueprint $table) {
                $table->id("REPMAIN_ID",11);
                $table->string('REPMAIN_YEAR')->nullable(); 
                $table->string('REPMAIN_MOUNT')->nullable(); 
                $table->String("REPMAIN_LISTTYPE_ID",255)->nullable();
                $table->String("REPMAIN_LISTTYPE_NAME",255)->nullable();   
                $table->float('REPMAIN_TOTAL_MAIN', 10, 5)->nullable();
                $table->float('REPMAIN_TOTAL_SUB', 10, 5)->nullable(); 
                $table->float('REPMAIN_TOTAL_MAINSUB', 10, 5)->nullable(); 
                $table->float('REPMAIN_TOTAL_BUY', 10, 5)->nullable(); 
                $table->float('REPMAIN_TOTAL_MAINSUBBUY', 10, 5)->nullable();
                $table->float('REPMAIN_TOTAL_PAY_RPST', 10, 5)->nullable(); 
                $table->float('REPMAIN_TOTAL_PAY_RPR_MAIN', 10, 5)->nullable(); 
                $table->float('REPMAIN_TOTAL_PAY_RPR_SUB', 10, 5)->nullable();   
                $table->float('REPMAIN_TOTAL_CUTMAIN', 10, 5)->nullable(); 
                $table->float('REPMAIN_TOTAL_CUTSUB', 10, 5)->nullable();
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
        Schema::dropIfExists('warehouse_reportmain');
    }
}
