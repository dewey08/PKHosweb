<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetCareSetupfuncTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('asset_care_setupfunc')){ 
               
            Schema::create('asset_care_setupfunc', function (Blueprint $table) {
                   $table->id("SETFUNCCARE_ID",11);
                   $table->String("SETFUNCCARE_NAME",50)->nullable(); 
                   $table->enum('ACTIVE',['True', 'False']); 
                   $table->dateTime('updated_at')->nullable();
                   $table->dateTime('created_at')->nullable();
               });


               DB::table('asset_care_setupfunc')->insert(array(
                   'SETFUNCCARE_ID' => '1',
                   'SETFUNCCARE_NAME' => 'ฟังก์ชันลัดขั้นตอนการบันทึกให้ดำเนินการสำเร็จ', 
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
        Schema::dropIfExists('asset_care_setupfunc');
    }
}
