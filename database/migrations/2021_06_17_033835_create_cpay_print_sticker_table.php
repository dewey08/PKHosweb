<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpayPrintStickerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('cpay_print_sticker')) {
            Schema::create('cpay_print_sticker', function (Blueprint $table) {
                $table->increments('CPAY_STICK_ID');
                $table->string('CAPY_STICK_NAME',255);
                $table->integer('CAPY_STICK_WIDTH');
                $table->integer('CAPY_STICK_HEIGHT');
                $table->text('CAPY_STICK_HTML_FORMAT');
                $table->string('CAPY_STICK_BRAND_PRINTER',255)->nullable();
                $table->string('CAPY_STICK_MODEL_PRINTER',255)->nullable();
                $table->boolean('CAPY_STICK_FOR_LIST');
                $table->text('CAPY_STICK_DETAIL')->nullable();
                $table->boolean('ACTIVE')->default(true);
                $table->string('UPDATED_BY',255);
                $table->timestamps();
            });
        }else{
            echo 'มีตารางนี้แล้ว : cpay_print_sticker  // ';
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cpay_print_sticker');
    }
}
