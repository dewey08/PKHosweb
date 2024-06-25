<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliesInvenPermissTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('supplies_inven_permiss'))
        {
        Schema::create('supplies_inven_permiss', function (Blueprint $table) {
            $table->increments("INVENPERMIS_ID",11);
            $table->string('INVENPERMIS_PERSON_ID')->nullable();
            $table->string('INVENPERMIS_INVEN_ID')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('created_at')->nullable();
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
        Schema::dropIfExists('supplies_inven_permiss');
    }
}
