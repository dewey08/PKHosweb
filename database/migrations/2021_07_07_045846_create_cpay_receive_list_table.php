<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpayReceiveListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('cpay_receive_list')) {
            Schema::create('cpay_receive_list', function (Blueprint $table) {
                $table->id('RECEIVE_LIST_ID');
                $table->bigInteger('RECEIVE_ID');
                $table->bigInteger('CPAY_SET_ID');
                $table->string('CPAY_SET_NAME');
                $table->string('PRODUCT_BARCODE')->nullable();
                $table->integer('RECEIVE_QUANTITY');
                $table->float('RECEIVE_PRICE');
                $table->float('RECEIVE_VALUE');
                $table->integer('BEFORE_SET_NOT_STERILE_QUANTITY');
                $table->integer('AFTER_SET_NOT_STERILE_QUANTITY');
                $table->bigInteger('RECEIVE_STATUS_ID');
                $table->bigInteger('RECEIVE_LIST_DETAIL');
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
        Schema::dropIfExists('cpay_receive_list');
    }
}
