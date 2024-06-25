<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHAPPYNETCOINTYPEToHappyNetCoinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('happy_net_coin', function (Blueprint $table) {
            if(!schema::hasColumn('happy_net_coin','HAPPY_NET_COIN_TYPE')){
                $table->String("HAPPY_NET_COIN_TYPE", 300)->nullable();
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
        Schema::table('happy_net_coin', function (Blueprint $table) {
            //
        });
    }
}
