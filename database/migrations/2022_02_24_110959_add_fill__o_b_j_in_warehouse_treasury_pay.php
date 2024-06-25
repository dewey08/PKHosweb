<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillOBJInWarehouseTreasuryPay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('warehouse_treasury_pay', function (Blueprint $table) {
            if(!schema::hasColumn('warehouse_treasury_pay','TREASURT_PAY_REQUEST_OBJ')){
                $table->string('TREASURT_PAY_REQUEST_OBJ',100)->nullable();
                
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
