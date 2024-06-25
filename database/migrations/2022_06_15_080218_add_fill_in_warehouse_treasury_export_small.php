<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillInWarehouseTreasuryExportSmall extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('warehouse_treasury_export_small', function (Blueprint $table) {

            if(!schema::hasColumn('warehouse_treasury_export_small','TREASURY_RECEIVE_ID')){
                $table->string('TREASURY_RECEIVE_ID',250)->nullable();               
            } 

            if(!schema::hasColumn('warehouse_treasury_export_small','TREASURY_EXPORT_SMALL_GEN_DATE')){
                $table->date('TREASURY_EXPORT_SMALL_GEN_DATE')->nullable();               
            } 

            if(!schema::hasColumn('warehouse_treasury_export_small','TREASURY_EXPORT_SMALL_EXP_DATE')){
                $table->date('TREASURY_EXPORT_SMALL_EXP_DATE')->nullable();               
            } 

            if(!schema::hasColumn('warehouse_treasury_export_small','WAREHOUSE_REQUEST_SMALL_ID')){
                $table->string('WAREHOUSE_REQUEST_SMALL_ID',250)->nullable();               
            } 

            if(!schema::hasColumn('warehouse_treasury_export_small','TREASURY_RECEIVE_SMALL_ID')){
                $table->string('TREASURY_RECEIVE_SMALL_ID',250)->nullable();               
            } 
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('warehouse_treasury_export_small', function (Blueprint $table) {
            //
        });
    }
}
