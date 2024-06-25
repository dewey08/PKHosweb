<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskRepItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('risk_rep_items'))
        {
        Schema::create('risk_rep_items', function (Blueprint $table) {
            // $table->foreignId("RISK_REPITEMS_ID",11)->unsigned(false);
            $table->id("RISK_REPITEMS_ID",11);
            $table->String("RISK_REPITEMS_CODE",255)->nullable();
            $table->String("RISK_REPITEMS_NAME",255)->nullable();
            $table->String("RISK_REPITEMS_DETAIL",500)->nullable();
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
        Schema::dropIfExists('risk_rep_items');
    }
}
