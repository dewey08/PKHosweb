<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillRepairSystemAssetCareRepair extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_care_repair', function (Blueprint $table) {
            if(!schema::hasColumn('asset_care_repair','REPAIR_SYSTEM')){
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
        Schema::table('asset_care_repair', function (Blueprint $table) {
            //
        });
    }
}
