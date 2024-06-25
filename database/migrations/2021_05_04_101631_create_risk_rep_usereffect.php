<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskRepUsereffect extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('risk_rep_usereffect'))
        {
        Schema::create('risk_rep_usereffect', function (Blueprint $table) {
            $table->id("RISK_REP_EFFECT_ID",11);
            $table->String("RISK_REPEFFECT_FULLNAME",255)->nullable();
            $table->String("RISK_REPEFFECT_AGE",255)->nullable();
            $table->String("RISK_REPEFFECT_SEX",255)->nullable();
            $table->String("RISK_REPEFFECT_HN",255)->nullable();
            $table->date('RISK_REPEFFECT_DATEIN')->nullable();
            $table->String("RISK_REPEFFECT_AN",255)->nullable();
            $table->date('RISK_REPEFFECT_DATEADMIN')->nullable();
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
        Schema::dropIfExists('risk_rep_usereffect');
    }
}
