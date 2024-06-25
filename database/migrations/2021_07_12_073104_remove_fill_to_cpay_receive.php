<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveFillToCpayReceive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cpay_receive', function (Blueprint $table) {
            if(schema::hasColumn('cpay_receive','RECEIVE_STATUS_ID')){
                $table->dropColumn('RECEIVE_STATUS_ID');
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
