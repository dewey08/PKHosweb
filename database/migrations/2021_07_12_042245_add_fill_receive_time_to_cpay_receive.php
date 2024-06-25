<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillReceiveTimeToCpayReceive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cpay_receive', function (Blueprint $table) {
            if(!Schema::hasColumn('cpay_receive','RECEIVE_TIME')){
                $table->time('RECEIVE_TIME');
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
        Schema::table('cpay_receive', function (Blueprint $table) {
            //
        });
    }
}
