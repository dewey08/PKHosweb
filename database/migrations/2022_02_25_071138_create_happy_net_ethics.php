<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHappyNetEthics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('happy_net_ethics')){
        
        Schema::create('happy_net_ethics', function (Blueprint $table) {
            $table->increments("HAPPY_NET_SET_ETHICS_ID", 11);
            $table->String("HAPPY_NET_SET_ETHICS", 350)->nullable();
            $table->String("HAPPY_NET_SET_ETHICS_CONTENT", 400)->nullable();
            $table->enum('HAPPY_NET_SET_ETHICS_STATUS', ['True', 'False']); 
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
        Schema::dropIfExists('happy_net_ethics');
    }
}
