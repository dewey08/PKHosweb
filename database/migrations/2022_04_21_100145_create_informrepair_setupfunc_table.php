<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformrepairSetupfuncTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('informrepair_setupfunc')){ 
               
             Schema::create('informrepair_setupfunc', function (Blueprint $table) {
                    $table->id("SETFUNC_ID",11);
                    $table->String("SETFUNC_NAME",50)->nullable(); 
                    $table->enum('ACTIVE',['True', 'False']); 
                    $table->dateTime('updated_at')->nullable();
                    $table->dateTime('created_at')->nullable();
                });


                DB::table('informrepair_setupfunc')->insert(array(
                    'SETFUNC_ID' => '1',
                    'SETFUNC_NAME' => 'ฟังก์ชันลัดขั้นตอนการบันทึกให้ดำเนินการสำเร็จ', 
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
        Schema::dropIfExists('informrepair_setupfunc');
    }
}
