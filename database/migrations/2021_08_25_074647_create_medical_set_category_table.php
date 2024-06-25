<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalSetCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('medical_set_category')){
            Schema::create('medical_set_category', function (Blueprint $table) {
                $table->id('SETCATEGORY_ID');
                $table->integer('SUP_TYPE_ID');
                $table->string('SETCATEGORY_NAME');
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
        Schema::dropIfExists('medical_set_category');
    }
}
