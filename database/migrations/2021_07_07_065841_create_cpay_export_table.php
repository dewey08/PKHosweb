<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpayExportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('cpay_export')) {
            Schema::create('cpay_export', function (Blueprint $table) {
                $table->id('EXPORT_ID');
                $table->bigInteger('SEND_TO_DEP_SUB_SUB_ID');
                $table->string('SEND_TO_DEP_SUB_SUB_NAME');
                $table->bigInteger('SEND_TO_PERSON_ID');
                $table->string('SEND_TO_PERSON_NAME');
                $table->bigInteger('SENDER_PERSON_ID');
                $table->string('SENDER_PERSON_NAME');
                $table->date('EXPORT_DATE');
                $table->time('EXPORT_TIME');
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
        Schema::dropIfExists('cpay_export');
    }
}
