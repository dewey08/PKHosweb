<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddenvElectricalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {      
        Schema::table('env_electrical', function (Blueprint $table) {
            if (!Schema::hasColumn('env_electrical', 'ELECTRICAL_NO'))
            {
                $table->String("ELECTRICAL_NO",255)->nullable();
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
        Schema::table('env_electrical', function (Blueprint $table) {
            
        });
    }
}
