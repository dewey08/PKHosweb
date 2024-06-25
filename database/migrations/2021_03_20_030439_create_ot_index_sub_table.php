<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtIndexSubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('ot_index_sub'))
{
    //
    Schema::create('ot_index_sub', function (Blueprint $table) {
        $table->increments("OT_ID",11);
        $table->String("OT_PERSON_ID",11);
        $table->String("OT_JOB",255);
        
        $table->String("OT_1DAY",255);
        $table->String("OT_2DAY",255);
        $table->String("OT_3DAY",255);
        $table->String("OT_4DAY",255);
        $table->String("OT_5DAY",255);
        $table->String("OT_6DAY",255);
        $table->String("OT_7DAY",255);
        $table->String("OT_8DAY",255);
        $table->String("OT_9DAY",255);
        $table->String("OT_10DAY",255);
        $table->String("OT_11DAY",255);
        $table->String("OT_12DAY",255);
        $table->String("OT_13DAY",255);
        $table->String("OT_14DAY",255);
        $table->String("OT_15DAY",255);
        $table->String("OT_16DAY",255);
        $table->String("OT_17DAY",255);
        $table->String("OT_18DAY",255);
        $table->String("OT_19DAY",255);
        $table->String("OT_20DAY",255);
        $table->String("OT_21DAY",255);
        $table->String("OT_22DAY",255);
        $table->String("OT_23DAY",255);
        $table->String("OT_24DAY",255);
        $table->String("OT_25DAY",255);
        $table->String("OT_26DAY",255);
        $table->String("OT_27DAY",255);
        $table->String("OT_28DAY",255);
        $table->String("OT_29DAY",255);
        $table->String("OT_30DAY",255);
        $table->String("OT_31DAY",255);
        
        $table->String("OT_SUM",255);
        $table->integer("OT_INDEX_ID")->length(11);
        $table->String("OT_RATE",255);
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
        Schema::dropIfExists('ot_index_sub');
    }
}
