<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddenvParameterSubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {    
        Schema::table('env_parameter_sub', function (Blueprint $table) {
            if (!Schema::hasColumn('env_parameter_sub', 'ANALYSIS_RESULTS'))
                {
                    $table->String("ANALYSIS_RESULTS",255)->nullable();
            }
            if (!Schema::hasColumn('env_parameter_sub', 'USEANALYSIS_RESULTS'))
            {
                $table->String("USEANALYSIS_RESULTS",255)->nullable();
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
        Schema::table('env_parameter_sub', function (Blueprint $table) {
            
        });
    }
}
