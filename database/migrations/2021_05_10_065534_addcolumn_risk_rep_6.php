<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddcolumnRiskRep6 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_rep',function (Blueprint $table) {           
            if (!Schema::hasColumn('risk_rep', 'RISKREP_INFER_EDIT'))
            {
                $table->string("RISKREP_INFER_EDIT",255)->nullable();
            }  
            if (!Schema::hasColumn('risk_rep', 'RISKREP_INFER_GROUPPROBLEM'))
            {
                $table->string("RISKREP_INFER_GROUPPROBLEM",255)->nullable();
            }           
            if (!Schema::hasColumn('risk_rep', 'RISKREP_INFER_PERFORMANCE'))
            {
                $table->string("RISKREP_INFER_PERFORMANCE",255)->nullable();
            }
            if (!Schema::hasColumn('risk_rep', 'RISKREP_INFER_IMPROVE'))
            {
                $table->string("RISKREP_INFER_IMPROVE",255)->nullable();
            }
            if (!Schema::hasColumn('risk_rep', 'RISKREP_INFER_DAYENDPROBLEM'))
            {
                $table->date("RISKREP_INFER_DAYENDPROBLEM")->nullable();
            }
            if (!Schema::hasColumn('risk_rep', 'RISKREP_INFER_USERSAVE'))
            {
                $table->string("RISKREP_INFER_USERSAVE",255)->nullable();
            }
            if (!Schema::hasColumn('risk_rep', 'RISKREP_INFER_DAYSAVE'))
            {
                $table->date("RISKREP_INFER_DAYSAVE")->nullable();
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
        //
    }
}
