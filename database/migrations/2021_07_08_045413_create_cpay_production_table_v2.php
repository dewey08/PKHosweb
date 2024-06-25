<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpayProductionTableV2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('cpay_production')) {
            Schema::create('cpay_production', function (Blueprint $table) {
            $table->id('PRODUCT_ID');
            $table->string('PRODUCT_BARCODE')->unique();
            $table->bigInteger('CPAY_DEP_ID');
            $table->string('CPAY_DEP_NAME');
            $table->bigInteger('MANUFACTURER_PERSON_ID');
            $table->string('MANUFACTURER_PERSON_NAME');
            $table->bigInteger('CHECK_PERSON_ID');
            $table->string('CEHCK_PERSON_NAME');
            $table->bigInteger('STERLIZE_PERSON_ID');
            $table->string('STERLIZE_PERSON_NAME');
            $table->bigInteger('CPAY_SET_ID');
            $table->string('CPAY_SET_NAME');
            $table->integer('PRODUCTION_QUANTITY_BALANCE');
            $table->integer('PRODUCTION_QUANTITY_EXPORT');
            $table->integer('PRODUCTION_QUANTITY');
            $table->float('PRODUCTION_PRICE');
            $table->float('PRODUCTION_VALUE');
            $table->integer('BEFORE_SET_NOT_STERILE_QUANTITY');
            $table->integer('AFTER_SET_NOT_STERILE_QUANTITY');
            $table->integer('BEFORE_SET_STERILE_QUANTITY');
            $table->integer('AFTER_SET_STERILE_QUANTITY');
            $table->integer('PRODUCTION_BALANCE_QUANTITY');
            $table->bigInteger('CPAY_MACH_ID');
            $table->integer('PRODUCTION_AROUND');
            $table->integer('CPAY_SET_STERILE_DAY');
            $table->date('PRODUCTION_DATE');
            $table->time('PRODUCTION_TIME');
            $table->date('EXPIRATION_DATE');
            $table->time('EXPIRATION_TIME');
            $table->boolean('IS_CANCEL')->default(false);;
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
        Schema::dropIfExists('cpay_production_table_v2');
    }
}
