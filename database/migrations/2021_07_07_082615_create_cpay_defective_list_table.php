<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpayDefectiveListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('cpay_defective_list')) {
            Schema::create('cpay_defective_list', function (Blueprint $table) {
                $table->id('DEFECTIVE_LIST_ID');
                $table->bigInteger('DEFECTIVE_ID');
                $table->bigInteger('CPAY_SET_ID');
                $table->bigInteger('PRODUCT_ID');
                $table->string('PRODUCT_BARCODE');
                $table->integer('DEFECTIVE_QUANTITY');
                $table->float('DEFECTIVE_PRICE');
                $table->float('DEFECTIVE_VALUE');
                $table->integer('BEFORE_SET_STERILE_QUANTITY');
                $table->integer('AFTER_SET_STERILE_QUANTITY');
                $table->bigInteger('DEFECTIVE_STATUS_ID');
                $table->string('DEFECTIVE_DETAIL');
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
        Schema::dropIfExists('cpay_defective_list');
    }
}
