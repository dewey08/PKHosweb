<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHappyNetOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('happy_net_order', function (Blueprint $table) {
            $table->increments("HAPPY_NET_ORDER_ID",11);
            $table->String("HAPPY_NET_ORDER_QUANTITY",50)->nullable();
            $table->enum('HAPPY_NET_ORDER_STATUS_COIN', ['True', 'False']); 
            $table->enum('HAPPY_NET_ORDER_STATUS', ['True', 'False']); 
            $table->dateTime('HAPPY_NET_ORDER_DATE')->nullable();
          
            $table->String("HAPPY_NET_NAME_USER",50)->nullable();
            $table->String("HAPPY_NET_NAME_PAY",50)->nullable();

            $table->integer('HAPPY_NET_REWARD_ID');
            $table->integer('HAPPY_NET_NAME_USER_ID');
            $table->integer('HAPPY_NET_NAME_PAY_ID');

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
        Schema::dropIfExists('happy_net_order');
    }
}
