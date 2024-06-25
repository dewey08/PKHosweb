<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpayExportListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('cpay_export_list')) {
            Schema::create('cpay_export_list', function (Blueprint $table) {
            $table->id('EXPORT_LIST_ID');
            $table->bigInteger('EXPORT_ID');
            $table->bigInteger('CPAY_SET_ID');
            $table->bigInteger('PRODUCT_ID');
            $table->string('PRODUCT_BARCODE');
            $table->string('CPAY_SET_NAME');
            $table->integer('SEND_TO_QUANTITY');
            $table->float('SEND_TO_PRICE');
            $table->float('SEND_TO_VALUE');
            $table->integer('BEFORE_SET_STERILE_QUANTITY');
            $table->integer('AFTER_SET_STERILE_QUANTITY');
            $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('export_list');
    }
}
