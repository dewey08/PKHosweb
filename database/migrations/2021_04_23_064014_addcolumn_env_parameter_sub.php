<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddcolumnEnvParameterSub extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('env_parameter_sub', function (Blueprint $table) {
            if (!Schema::hasColumn('env_parameter_sub', 'LIST_PARAMETER_IDD'))
            {
                $table->string("LIST_PARAMETER_IDD",11)->nullable();
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
