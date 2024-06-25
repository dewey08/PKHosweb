<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddcolumnEnvElectricalSub extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('env_electrical_sub', function (Blueprint $table) {
            if (!Schema::hasColumn('env_electrical_sub', 'ELECTRICAL_SUB_CHECK_ID'))
            {
                $table->string("ELECTRICAL_SUB_CHECK_ID")->nullable();
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
        Schema::table('env_electrical_sub', function (Blueprint $table) {
            
        });
    }
}
