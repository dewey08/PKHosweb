<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillTrasurtPaySmallIdInWarehouseTreasuryExportSmall extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('warehouse_treasury_export_small', function (Blueprint $table) {
            if(!schema::hasColumn('warehouse_treasury_export_small','TREASURT_PAY_SMALL_ID')){
                $table->integer('TREASURT_PAY_SMALL_ID')->nullable();               
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
