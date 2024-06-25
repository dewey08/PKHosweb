<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        if (!Schema::hasTable('ins_eclaimxxx'))
        {
            Schema::connection('mysql7')->create('ins_eclaimxxx', function (Blueprint $table) {
                $table->bigIncrements('ins_eclaimxxx_id'); 
                $table->string('hipdata')->nullable();//
                $table->string('icodex')->nullable();//  
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
        Schema::dropIfExists('ins_eclaimxxx');
    }
};
