<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillRepairSystemInformrepairIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('informrepair_index', function (Blueprint $table) {
            if(!schema::hasColumn('informrepair_index','REPAIR_SYSTEM')){
                $table->string('REPAIR_SYSTEM')->nullable();
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
        Schema::table('informrepair_index', function (Blueprint $table) {
            //
        });
    }
}
