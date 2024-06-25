<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHappyNetShop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('happy_net_shop'))
        { 
        Schema::create('happy_net_shop', function (Blueprint $table) {
            $table->increments("HAPPY_NET_SHOP_ID", 11);
            $table->integer('ID_USER');
            $table->integer('HAPPY_NET_REWARD_ID');
            $table->String("HAPPY_NET_COIN_SHOP", 300)->nullable();
            $table->String("HAPPY_NET_SHOP_TYPE", 50)->nullable();
            $table->String("HAPPY_NET_SHOP_QUANTITY", 300)->nullable();

            $table->dateTime('updated_at')->nullable();
            $table->dateTime('created_at')->nullable();
        });

    }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('happy_net_shop');
    }
}
