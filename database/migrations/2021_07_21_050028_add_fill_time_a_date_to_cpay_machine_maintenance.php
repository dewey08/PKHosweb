<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillTimeADateToCpayMachineMaintenance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cpay_machine_maintenance', function (Blueprint $table) {
            if(!schema::hasColumn('cpay_machine_maintenance','MMAINTENANCE_TEST_TIME')){
                $table->time('MMAINTENANCE_TEST_TIME');
            }
            if(!schema::hasColumn('cpay_machine_maintenance','MMAINTENANCE_DETAIL')){
                $table->string('MMAINTENANCE_DETAIL',400)->nullable();
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
        Schema::table('cpay_machine_maintenance', function (Blueprint $table) {
            //
        });
    }
}
