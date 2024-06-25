<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnvPlumbingConditionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('env_plumbing_condition'))
        {
        Schema::create('env_plumbing_condition', function (Blueprint $table) {
            $table->id("PLUMBING_CONDITION_ID",11);
            $table->String("PLUMBING_CONDITION_NAME",255)->nullable();
            $table->dateTime("updated_at")->nullable();
            $table->dateTime("created_at")->nullable();
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
        Schema::dropIfExists('env_plumbing_condition');
      
    }
}
