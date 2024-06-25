<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskRepDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('risk_rep_detail'))
        {
        Schema::create('risk_rep_detail', function (Blueprint $table) {
            // $table->foreignId("RISK_REPDETAIL_ID",11)->unsigned(false);
            $table->id("RISK_REPDETAIL_ID",11);
            $table->String("RISK_REPDETAIL_CODE",255)->nullable();
            $table->String("RISK_REPDETAIL_NAME",255)->nullable();
            $table->String("RISK_GROUPSUBSUB_ID",100)->nullable();
            $table->String("RISK_GROUPSUB_ID",100)->nullable();
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
        Schema::dropIfExists('risk_rep_detail');
    }
}
