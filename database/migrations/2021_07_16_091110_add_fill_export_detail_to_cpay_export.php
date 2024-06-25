<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillExportDetailToCpayExport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cpay_export', function (Blueprint $table) {
            if(!schema::hasColumn('cpay_export','EXPORT_DETAIL')){
                $table->text('EXPORT_DETAIL')->nullable();
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
        Schema::table('cpay_export', function (Blueprint $table) {
            //
        });
    }
}
