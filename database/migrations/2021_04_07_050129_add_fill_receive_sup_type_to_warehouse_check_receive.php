<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillReceiveSupTypeToWarehouseCheckReceive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('warehouse_check_receive', function (Blueprint $table) {
            if (!Schema::hasColumn('warehouse_check_receive', 'RECEIVE_SUP_TYPE'))
            {
                $table->String("RECEIVE_SUP_TYPE",255)->nullable();
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
        Schema::table('warehouse_check_receive', function (Blueprint $table) {
            //
        });
    }
}
