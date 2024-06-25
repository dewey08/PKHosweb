<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPumpingFil extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('env_plumbing', function (Blueprint $table) {
            if (!Schema::hasColumn('env_plumbing', 'PLUMBING_REC_NO'))
            {
                $table->String("PLUMBING_REC_NO",255)->nullable();
            }
            if (!Schema::hasColumn('env_plumbing', 'PLUMBING_EMBLEM'))
            {
                $table->String("PLUMBING_EMBLEM",255)->nullable();
            }
            if (!Schema::hasColumn('env_plumbing', 'PLUMBING_NO_SEND'))
            {
                $table->String("PLUMBING_NO_SEND",255)->nullable();
            }
            if (!Schema::hasColumn('env_plumbing', 'PLUMBING_GROUP_EX'))
            {
                $table->String("PLUMBING_GROUP_EX",255)->nullable();
            }
            if (!Schema::hasColumn('env_plumbing', 'PLUMBING_CONDITION'))
            {
                $table->String("PLUMBING_CONDITION",255)->nullable();
            }
            if (!Schema::hasColumn('env_plumbing', 'PLUMBING_ENVIRONMENT'))
            {
                $table->String("PLUMBING_ENVIRONMENT",255)->nullable();
            }
            if (!Schema::hasColumn('env_plumbing', 'PLUMBING_DEPRAT_SUBSUB'))
            {
                $table->String("PLUMBING_DEPRAT_SUBSUB",255)->nullable();
            }
            if (!Schema::hasColumn('env_plumbing', 'PLUMBING_LOCATION'))
            {
                $table->String("PLUMBING_LOCATION",255)->nullable();
            }
            if (!Schema::hasColumn('env_plumbing', 'PLUMBING_CH'))
            {
                $table->String("PLUMBING_CH",255)->nullable();
            }
            if (!Schema::hasColumn('env_plumbing', 'PLUMBING_AM'))
            {
                $table->String("PLUMBING_AM",255)->nullable();
            }
            if (!Schema::hasColumn('env_plumbing', 'PLUMBING_REC_DATE'))
            {
                $table->String("PLUMBING_REC_DATE")->nullable();
            }
            if (!Schema::hasColumn('env_plumbing', 'PLUMBING_ANALYZE_DATE'))
            {
                $table->String("PLUMBING_ANALYZE_DATE")->nullable();
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
        Schema::table('env_plumbing', function (Blueprint $table) {
           
        });
    }
}
