<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPumpingSubfil extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('env_plumbing_sub', function (Blueprint $table) {
            if (!Schema::hasColumn('env_plumbing_sub', 'PLUMBING_SUB_TEST'))
            {
                $table->String("PLUMBING_SUB_TEST",255)->nullable();
            }
            if (!Schema::hasColumn('env_plumbing_sub', 'PLUMBING_SUB_UNIT'))
            {
                $table->String("PLUMBING_SUB_UNIT",255)->nullable();
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
        Schema::table('env_plumbing_sub', function (Blueprint $table) {
         
        });
    }
}
