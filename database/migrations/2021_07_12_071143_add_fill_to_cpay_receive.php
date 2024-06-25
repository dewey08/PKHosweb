<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillToCpayReceive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cpay_receive', function (Blueprint $table) {
            if(!Schema::hascolumn('cpay_receive','RECEIVE_CANCEL_BY')){
                $table->string('RECEIVE_CANCEL_BY');
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
