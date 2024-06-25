<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformrepairOpenform extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {      
        if (!Schema::hasTable('informrepair_openform'))
        {
                Schema::create('informrepair_openform', function (Blueprint $table) {
                    $table->id("OPENFORM_ID",11);
                    $table->String("OPENFORM_CODE",255)->nullable(); 
                    $table->String("OPENFORM_NAME",255)->nullable(); 
                    $table->enum('OPENFORM_STATUS', ['True', 'False']);   
                    $table->dateTime('updated_at');
                    $table->dateTime('created_at');
                }); 
        }

        if (Schema::hasTable('informrepair_openform')) {
            DB::table('informrepair_openform')->truncate();
        }

        DB::table('informrepair_openform')->insert(array(
            'OPENFORM_ID' => '1',
            'OPENFORM_CODE' => 'REPAIRNORMAL',
            'OPENFORM_NAME' => 'ฟังก์ชันสร้างฟอร์มแจ้งซ่อมทั่วไป',
            'OPENFORM_STATUS' => 'True',
            'updated_at' => '2021-12-08 14:52:49',
            'created_at' => '2021-12-08 14:52:49',
        ));



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('informrepair_openform');
    }
}
