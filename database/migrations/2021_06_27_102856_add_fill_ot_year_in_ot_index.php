<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillOtYearInOtIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ot_index', function (Blueprint $table) {
            if (!Schema::hasColumn('ot_index', 'OT_YEAR'))
            {
                $table->string("OT_YEAR",50)->nullable();
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
        Schema::table('ot_index', function (Blueprint $table) {
            //
        });
    }
}
