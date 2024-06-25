<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHAPPYNETSHOPQUANTITYToHappyNetShop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('happy_net_shop', function (Blueprint $table) {
            if(!schema::hasColumn('happy_net_shop','HAPPY_NET_SHOP_QUANTITY')){
                $table->String("HAPPY_NET_SHOP_QUANTITY", 300)->nullable();
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
