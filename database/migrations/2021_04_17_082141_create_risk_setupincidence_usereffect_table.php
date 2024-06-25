<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskSetupincidenceUsereffectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('risk_setupincidence_usereffect'))
        {
        Schema::create('risk_setupincidence_usereffect', function (Blueprint $table) {
            $table->id("INCEDENCE_USEREFFECT_ID",11);
            $table->String("INCEDENCE_USEREFFECT_NAME",255)->nullable();
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
        Schema::dropIfExists('risk_setupincidence_usereffect');
    }
}
