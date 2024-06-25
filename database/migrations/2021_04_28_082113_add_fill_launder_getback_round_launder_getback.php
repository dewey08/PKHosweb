<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillLaunderGetbackRoundLaunderGetback extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('launder_getback', function (Blueprint $table) {
            if (!Schema::hasColumn('launder_getback', 'LAUNDER_GETBACK_ROUND'))
            {
                $table->String("LAUNDER_GETBACK_ROUND",100)->nullable();
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
        Schema::table('launder_getback', function (Blueprint $table) {
          //
        
        });
    }
}
