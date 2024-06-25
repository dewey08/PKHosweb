<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRiskRepColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_rep', function (Blueprint $table) {
            if (!Schema::hasColumn('risk_rep', 'RISK_REP_IMG'))
            {
                $table->binary("RISK_REP_IMG")->nullable();
            }
            if (!Schema::hasColumn('risk_rep', 'RISKREP_NO'))
            {
                $table->binary("RISKREP_NO")->nullable();
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
