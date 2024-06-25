<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillReceiveCheckStorDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('warehouse_check_receive', function (Blueprint $table) {
           

            if(!schema::hasColumn('warehouse_check_receive','RECEIVE_CHECKSTOR_DATE')){
                $table->date('RECEIVE_CHECKSTOR_DATE')->nullable();
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
