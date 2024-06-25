<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBudgetYear extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_rep', function (Blueprint $table) {
            if (!Schema::hasColumn('risk_rep', 'BUDGET_YEAR'))
            {
                $table->String("BUDGET_YEAR",255)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('risk_rep', function (Blueprint $table) {
            
        });
    }
}
