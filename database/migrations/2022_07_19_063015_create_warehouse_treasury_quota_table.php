<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseTreasuryQuotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('warehouse_treasury_quota')){ 

            Schema::create('warehouse_treasury_quota', function (Blueprint $table) {
            $table->id("WAREHOUSE_TREASARY_QUOTA_ID",11); 
            $table->String("WAREHOUSE_TREASARY_QUOTA_DEP_ID",255)->nullable(); 
            $table->String("WAREHOUSE_TREASARY_QUOTA_SUP_ID",255)->nullable();
            $table->String("WAREHOUSE_TREASARY_QUOTA_SUP_CODE",255)->nullable();
            $table->String("WAREHOUSE_TREASARY_QUOTA_AMOUNT",255)->nullable();
            $table->String("WAREHOUSE_TREASARY_QUOTA_MIN",255)->nullable();
            $table->String("WAREHOUSE_TREASARY_QUOTA_MAX",255)->nullable();
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
        Schema::dropIfExists('warehouse_treasury_quota_table');
    }
}
