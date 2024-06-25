<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskRepItemsSubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('risk_rep_items_sub'))
        {
        Schema::create('risk_rep_items_sub', function (Blueprint $table) {
            $table->id("RISK_REPITEMSSUB_ID",11);
            $table->String("RISK_REPITEMSSUB_CODE",255)->nullable();
            $table->String("RISK_REPITEMSSUB_NAME",255)->nullable();
            $table->String("RISK_REPITEMS_ID",11)->nullable();
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
        Schema::dropIfExists('risk_rep_items_sub');
    }
}
