<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('risk_rep_group'))
        {
        Schema::create('risk_rep_group', function (Blueprint $table) {
            // $table->foreignId("RISK_GROUP_ID")->unsigned(false);
            // $table->String("RISK_GROUP_ID",11)->primary();
            $table->id("RISK_GROUP_ID",11);
            $table->String("RISK_GROUP_CODE",255)->nullable();
            $table->String("RISK_GROUP_NAME")->nullable();
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
        Schema::dropIfExists('risk_rep_group');
    }
}
