<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddcolumnRiskRep3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_rep',function (Blueprint $table) {
            if (!Schema::hasColumn('risk_rep', 'RISKREP_TYPEDEP'))
            {
                $table->string("RISKREP_TYPEDEP",255)->nullable();
            }
            if (!Schema::hasColumn('risk_rep', 'RISKREP_TYPEDEP_NAME'))
            {
                $table->string("RISKREP_TYPEDEP_NAME",255)->nullable();
            }
            if (!Schema::hasColumn('risk_rep', 'RISKREP_DATENOTIFY'))
            {
                $table->date("RISKREP_DATENOTIFY")->nullable();
            }
            if (!Schema::hasColumn('risk_rep', 'RISKREP_TYPESUB'))
            {
                $table->string("RISKREP_TYPESUB",255)->nullable();
            }
            if (!Schema::hasColumn('risk_rep', 'RISKREP_TYPESUB_NAME'))
            {
                $table->string("RISKREP_TYPESUB_NAME",255)->nullable();
            }
            if (!Schema::hasColumn('risk_rep', 'RISKREP_DATECONFIRM'))
            {
                $table->date('RISKREP_DATECONFIRM')->nullable();
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
