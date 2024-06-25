<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtIndexTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('ot_index'))
{
    Schema::create('ot_index', function (Blueprint $table) {
        $table->increments("OT_INDEX_ID",11);
        $table->String("OT_MONTH",255);
        $table->String("OT_DEP_SUB_SUB",255);
        $table->String("OT_TYPE",255);
        $table->String("OT_INDEX_PERSON_ID",255);
        $table->String("OT_PERSON_NAME",255);
        $table->String("OT_AMOUNT_PERSON",255);
        $table->String("OT_BUGGET_SUM",255);
        $table->String("OT_STATUS",50);
        $table->dateTime("updated_at");
        $table->dateTime("created_at");
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
        Schema::dropIfExists('ot_index');
    }
}
