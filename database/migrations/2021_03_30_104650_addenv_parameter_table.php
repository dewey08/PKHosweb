<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddenvParameterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('env_parameter', function (Blueprint $table) {
            if (!Schema::hasColumn('env_parameter', 'LOCATION_EX'))
            {
                $table->String("LOCATION_EX",255)->nullable();
            }
            if (!Schema::hasColumn('env_parameter', 'GROUP_EXCAMPLE'))
            {
                $table->String("GROUP_EXCAMPLE",255)->nullable();
            }
            if (!Schema::hasColumn('env_parameter', 'LOCATION_EXDATE'))
            {
                $table->dateTime('LOCATION_EXDATE')->nullable();
            }
            if (!Schema::hasColumn('env_parameter', 'GROUP_EXCAMPLEDATE'))
            {
                $table->dateTime('GROUP_EXCAMPLEDATE')->nullable();
            }
            if (!Schema::hasColumn('env_parameter', 'USER_EXCAMPLE'))
            {
                $table->String("USER_EXCAMPLE",255)->nullable();
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
        Schema::table('env_parameter', function (Blueprint $table) {
           
        });
    }
}
