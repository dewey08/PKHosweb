<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpayUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('cpay_unit')) {
            Schema::create('cpay_unit', function (Blueprint $table) {
                $table->increments('CPAY_UNIT_ID');
                $table->string('CPAY_UNIT_NAME',255);
                $table->text('CPAY_UNIT_DETAIL')->nullable();
                $table->boolean('ACTIVE')->default(true);
                $table->string('UPDATED_BY',255);
                $table->timestamps();
            });
        }else{
            echo 'มีตารางนี้แล้ว : cpay_unit  //';
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cpay_unit');
    }
}
