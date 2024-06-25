<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillRepairIdWarehouseTreasuryPay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('warehouse_treasury_pay', function (Blueprint $table) {
            if (!Schema::hasColumn('warehouse_treasury_pay', 'REPAIR_ID'))
            {
                $table->string("REPAIR_ID",50)->nullable();
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
        Schema::table('warehouse_treasury_pay', function (Blueprint $table) {
            //
        });
    }
}
