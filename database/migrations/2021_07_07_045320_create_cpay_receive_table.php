<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpayReceiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('cpay_receive')) {
            Schema::create('cpay_receive', function (Blueprint $table) {
                $table->id('RECEIVE_ID');
                $table->bigInteger('DELIVERY_DEP_SUB_SUB_ID');
                $table->string('DELIVERY_DEP_SUB_SUB_NAME');
                $table->bigInteger('DELIVERY_PERSON_ID');
                $table->string('DELIVERY_PERSON_NAME');
                $table->bigInteger('RECEIVE_PERSON_ID');
                $table->string('RECEIVE_PERSON_NAME');
                $table->date('RECEIVE_DATE');
                $table->date('RECEIVE_TIME');
                $table->boolean('IS_CANCEL')->default(false);
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
        Schema::dropIfExists('cpay_receive');
    }
}
