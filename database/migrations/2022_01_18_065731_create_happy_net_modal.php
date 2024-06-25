<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHappyNetModal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('happy_net_modal'))
        {
        Schema::create('happy_net_modal', function (Blueprint $table) {
            $table->increments("HAPPY_NET_MODAL_QUESTION_ID", 11);
            $table->enum('HAPPY_NET_MODAL_QUESTION', ['True', 'False']); 
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
        Schema::dropIfExists('happy_net_modal');
    }
}
