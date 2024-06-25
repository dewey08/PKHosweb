<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnQuantityExportToCpayProduction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cpay_production', function (Blueprint $table) {
            if(schema::hasColumn('cpay_production','PRODUCTION_QUANTITY_EXPORT')){
                $table->dropColumn('PRODUCTION_QUANTITY_EXPORT');
            }
            if(schema::hasColumn('cpay_production','PRODUCTION_BALANCE_QUANTITY')){
                $table->dropColumn('PRODUCTION_BALANCE_QUANTITY');
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
        Schema::table('cpay_production', function (Blueprint $table) {
            //
        });
    }
}
