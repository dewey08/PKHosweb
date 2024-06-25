<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpayDefectiveStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('cpay_defective_status')) {
            Schema::create('cpay_defective_status', function (Blueprint $table) {
            $table->id('DEFECTIVE_STATUS_ID');
            $table->string('DEFECTIVE_STATUS_NAME');
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
        Schema::dropIfExists('defective_status');
    }
}
