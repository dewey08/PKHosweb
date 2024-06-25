<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliesOfficerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable('supplies_officer'))
        {
            Schema::create('supplies_officer', function (Blueprint $table) {
                $table->increments("SUP_OFFICER_ID",11);
                $table->String("SUP_OFFICER_PERSON_ID",255)->nullable();
                $table->String("SUP_OFFICER_PERSON_NAME",255)->nullable();
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
        Schema::dropIfExists('supplies_officer');
    }
}
