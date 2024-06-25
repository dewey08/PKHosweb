<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGleavePernisLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('gleave_permis_level')) {

            Schema::create('gleave_permis_level', function (Blueprint $table) {

                $table->increments("PERMIS_LEVEL_ID",11);
                $table->String("PERSON_ID",255)->nullable();
                $table->String("NAME_PERSON",255)->nullable();
                $table->String("DEP_SUB_SUB_ID",255)->nullable();
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
        Schema::dropIfExists('gleave_permis_level');
    }
}
