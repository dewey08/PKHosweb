<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSETUPPLUMBINGUNITToEnvPlumbingSetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('env_plumbing_set', function (Blueprint $table) {
            if(!schema::hasColumn('env_plumbing_set','SETUP_PLUMBING_UNIT')){
                $table->String("SETUP_PLUMBING_UNIT", 300)->nullable();
              
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
        Schema::table('env_plumbing_set', function (Blueprint $table) {
            //
        });
    }
}
