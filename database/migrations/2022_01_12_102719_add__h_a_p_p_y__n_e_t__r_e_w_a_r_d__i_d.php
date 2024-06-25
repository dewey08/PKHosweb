<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHAPPYNETREWARDID extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('happy_net_shop', function (Blueprint $table) {
            if(!schema::hasColumn('happy_net_shop','HAPPY_NET_REWARD_ID')){
                $table->integer('HAPPY_NET_REWARD_ID');
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
        Schema::table('happy_net_shop', function (Blueprint $table) {
            //
        });
    }
}
