<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddenvOxigenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('env_oxigen', function (Blueprint $table) {
            if (!Schema::hasColumn('env_oxigen', 'OXIGEN_CHECK_NAME'))
            {
                $table->String("OXIGEN_CHECK_NAME",255)->nullable();
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
        Schema::table('env_oxigen', function (Blueprint $table) {
            
        });
    }
}
