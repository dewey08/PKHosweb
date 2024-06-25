<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToHappyNetOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('happy_net_order', function (Blueprint $table) {
            if(!schema::hasColumn('happy_net_order','HAPPY_NET_REWARD_NAME')){
                $table->string('HAPPY_NET_REWARD_NAME')->nullable();
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
        Schema::table('happy_net_order', function (Blueprint $table) {
            //
        });
    }
}
