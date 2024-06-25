<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformrepairFunctionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('infomrepair_function')){ 
        Schema::create('infomrepair_function', function (Blueprint $table) {
            $table->increments("REPAIRFUNCTION_ID",11);
            $table->string('REPAIRFUNCTION_NAME')->nullable();
            $table->enum('ACTIVE', ['True', 'False']);
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('created_at')->nullable();
        });


        DB::table('infomrepair_function')->insert(array(
            'REPAIRFUNCTION_NAME' => 'ใช้ใบแจ้งซ่อมของโรงพยาบาล',
            'ACTIVE' => 'True',
           
        ));
    }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('infomrepair_function');
    }
}
