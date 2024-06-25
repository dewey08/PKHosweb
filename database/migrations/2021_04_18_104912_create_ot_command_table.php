<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtCommandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('ot_command'))
        {
        Schema::create('ot_command', function (Blueprint $table) {
            $table->increments("OT_COMMAND_ID",11);
            $table->String("OT_INDEX_ID",255);
            $table->String("OT_DETAIL",5000);
            $table->dateTime("updated_at");
            $table->dateTime("created_at");
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
        Schema::dropIfExists('ot_command');
    }
}
