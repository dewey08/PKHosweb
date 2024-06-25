<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoworkKpi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!schema::hasTable('infowork_kpi')){
            Schema::create('infowork_kpi', function (Blueprint $table) {
                $table->id('IWKPI_ID');
                $table->string('IWKPI_NAME');
                $table->float('IWKPI_NUMBER_1',5,2);
                $table->float('IWKPI_NUMBER_2',5,2);
                $table->float('IWKPI_NUMBER_3',5,2);
                $table->float('IWKPI_NUMBER_4',5,2);
                $table->float('IWKPI_NUMBER_5',5,2);
                $table->float('IWKPI_SCORE_A',5,2);
                $table->float('IWKPI_WEIGHT_B',5,2);
                $table->float('IWKPI_MULTIPLY_AB',9,2);
                $table->float('IWKPI_TARGET',5,2);
                $table->boolean('IWKPI_ACTIVE')->default(1);
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
        Schema::dropIfExists('infowork_kpi');
    }
}