<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHappyNetCompliment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('happy_net_compliment'))
        { 
        Schema::create('happy_net_compliment', function (Blueprint $table) {
            $table->increments("HAPPY_NET_COIMPLIMENT_ID", 11);
            $table->String("HAPPY_NET_COIMPLIMENT", 900)->nullable();
            $table->integer('ID_USER');
            $table->integer('HAPPY_NET_DIFFICULTY_ID');
            $table->String("HAPPY_NET_COIMPLIMENT_FNAME", 250)->nullable();
            $table->String("HAPPY_NET_COIMPLIMENT_LNAME", 250)->nullable();
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
        Schema::dropIfExists('happy_net_compliment');
    }
}
