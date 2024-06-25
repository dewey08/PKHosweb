<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskGroupSubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('risk_rep_groupsub'))
        {
        Schema::create('risk_rep_groupsub', function (Blueprint $table) {
            // $table->foreignId("RISK_GROUPSUB_ID",11)->unsigned(false);
            // $table->String("RISK_GROUPSUB_ID",11)->primary();
            $table->id("RISK_GROUPSUB_ID",11);
            $table->String("RISK_GROUPSUB_CODE",255)->nullable();
            $table->String("RISK_GROUPSUB_NAME",255)->nullable();
            $table->String("RISK_GROUP_ID",100)->nullable();
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
        Schema::dropIfExists('risk_rep_groupsub');
    }
}
