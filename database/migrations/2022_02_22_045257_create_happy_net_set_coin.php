<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHappyNetSetCoin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('happy_net_set_coin'))
        {

            Schema::create('happy_net_set_coin', function (Blueprint $table) {
            
                    $table->increments("HAPPY_NET_SET_COIN_ID", 11);
                    $table->String("HAPPY_NET_SET_COIN", 250)->nullable();
                    $table->enum('HAPPY_NET_SET_COIN_STATUS', ['True', 'False']); 
                    $table->date('DATE_SAVE')->nullable();
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
        Schema::dropIfExists('happy_net_set_coin');
    }
}
