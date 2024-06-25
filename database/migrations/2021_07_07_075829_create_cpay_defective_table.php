<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpayDefectiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('cpay_defective')) {
            Schema::create('cpay_defective', function (Blueprint $table) {
                $table->id('DEFECTIVE_ID');
                $table->bigInteger('DESTROYER_PERSON_ID');
                $table->string('DESTROYER_PERSON_NAME');
                $table->date('DEFECTIVE_DATE');
                $table->time('DEFECTIVE_TIME');
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
        Schema::dropIfExists('defective');
    }
}
