<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHappyNetReward extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('happy_net_reward', function (Blueprint $table) {
            $table->increments("HAPPY_NET_REWARD_ID",11);
            $table->String("HAPPY_NET_REWARD_NAME",255)->nullable();
            $table->String("HAPPY_NET_REWARD_DETAILS",300)->nullable();
            $table->string("HAPPY_NET_REWARD_PRICE",40)->nullable();
            $table->string("HAPPY_NET_REWARD_QUANTITY",40)->nullable();
            $table->enum('HAPPY_NET_REWARD_STATUS', ['True', 'False']); 
            $table->binary('HAPPY_NET_REWARD_IMAGE');  
            $table->String("HAPPY_NET_REWARD_DETAILS2",300)->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('happy_net_reward');
    }
}
