<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillRiskrepAccIdInRiskRep extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_rep', function (Blueprint $table) {
            if (!Schema::hasColumn('risk_rep', 'RISKREP_ACC_ID'))
            {
                $table->string("RISKREP_ACC_ID",255)->nullable();
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
            //
        });
    }
}
