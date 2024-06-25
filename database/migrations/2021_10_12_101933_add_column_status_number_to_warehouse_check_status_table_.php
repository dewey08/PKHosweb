<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnStatusNumberToWarehouseCheckStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(schema::hasTable('warehouse_check_status')){
            Schema::table('warehouse_check_status', function (Blueprint $table) {
                if(!schema::hasColumn('warehouse_check_status','STATUS_NUMBER')){
                    $table->integer('STATUS_NUMBER')->nullable();
                }
            });
            DB::table('warehouse_check_status')->where('ID_STATUS',2)->update([
                'STATUS_NUMBER' => 1
            ]);
            DB::table('warehouse_check_status')->where('ID_STATUS',3)->update([
                'STATUS_NUMBER' => 2
            ]);
            DB::table('warehouse_check_status')->where('ID_STATUS',1)->update([
                'STATUS_NUMBER' => 3
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('warehouse_check_status', function (Blueprint $table) {
            //
        });
    }
}
