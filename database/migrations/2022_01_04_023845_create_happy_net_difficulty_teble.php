<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHappyNetDifficultyTeble extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('happy_net_difficulty_teble', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        // });
        if(!Schema::hasTable('happy_net_difficulty')) {

            Schema::create('happy_net_difficulty', function (Blueprint $table) {
                $table->increments("HAPPY_NET_DIFFICULTY_ID",11);
                $table->String("HAPPY_NET_DIFFICULTY",255)->nullable();
                $table->string("HAPPY_NET_DIFFICULTY_COIN",40)->nullable();
                $table->enum('HAPPY_NET_DIFFICULTY_STATUS', ['True', 'False']);   
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
        Schema::dropIfExists('happy_net_difficulty_teble');
    }
}
