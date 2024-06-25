<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformcomSetupfuncTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('informcom_setupfunc')){ 
               
            Schema::create('informcom_setupfunc', function (Blueprint $table) {
                   $table->id("SETFUNCCOM_ID",11);
                   $table->String("SETFUNCCOM_NAME",50)->nullable(); 
                   $table->enum('ACTIVE',['True', 'False']); 
                   $table->dateTime('updated_at')->nullable();
                   $table->dateTime('created_at')->nullable();
               });


               DB::table('informcom_setupfunc')->insert(array(
                   'SETFUNCCOM_ID' => '1',
                   'SETFUNCCOM_NAME' => 'ฟังก์ชันลัดขั้นตอนการบันทึกให้ดำเนินการสำเร็จ', 
                   'ACTIVE' => 'False',     
                   'created_at' => date('Y-m-d H:i:s'),
                   'updated_at' => date('Y-m-d H:i:s'),
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
        Schema::dropIfExists('informcom_setupfunc');
    }
}
