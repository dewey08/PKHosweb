<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskRepDepartmentSubsubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('risk_rep_department_subsub'))
        {
        Schema::create('risk_rep_department_subsub', function (Blueprint $table) {
            $table->id("RISK_REP_DEPARTMENT_SUBSUBID",11);
            $table->String("RISK_REP_DEPARTMENT_SUBSUBNAME",255)->nullable();          
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
        Schema::dropIfExists('risk_rep_department_subsub');
    }
}
