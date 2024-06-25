<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdTrFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('hrd_tr_file'))
        {

        Schema::create('hrd_tr_file', function (Blueprint $table) {
            $table->increments("ID",11);
            $table->integer("PERSON_ID");
            $table->String("FILE_NAME",500);
            $table->binary('FILE_PERSON');
            $table->date('DATE_SAVE');
            $table->dateTime('updated_at');
            $table->dateTime('created_at');

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
        Schema::dropIfExists('hrd_tr_file');
    }
}
