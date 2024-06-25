<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeReceiveDetailListNullFillToCpayReceiveList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cpay_receive_list', function (Blueprint $table) {
            if(schema::hasColumn('cpay_receive_list','RECEIVE_LIST_DETAIL')){
                $table->string('RECEIVE_LIST_DETAIL')->nullable()->change();
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
        Schema::table('cpay_receive_list', function (Blueprint $table) {
            //
        });
    }
}
