<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskRepProgramSubsubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('risk_rep_program_subsub'))
        {
        Schema::create('risk_rep_program_subsub', function (Blueprint $table) {
            $table->id("RISK_REPPROGRAMSUBSUB_ID",11);          
            $table->String("RISK_REPPROGRAMSUBSUB_NAME",255)->nullable();
            $table->String("RISK_REPPROGRAMSUBSUB_DETAIL",500)->nullable();
            $table->String("RISK_REPPROGRAMSUB_ID",11)->nullable();
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
        Schema::dropIfExists('risk_rep_program_subsub');
    }
}
