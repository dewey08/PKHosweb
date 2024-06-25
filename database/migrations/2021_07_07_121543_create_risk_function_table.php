<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskFunctionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        if (!Schema::hasTable('risk_function'))
        {
                Schema::create('risk_function', function (Blueprint $table) {
                    $table->id("RISK_FUNCTION_ID",11);
                    $table->String("RISK_FUNCTION_NAME",255)->nullable(); 
                    $table->enum('ACTIVE', ['True','False']);
                    $table->dateTime('updated_at')->nullable();
                    $table->dateTime('created_at')->nullable();
                });
    
                DB::table('risk_function')->insert([
                    'RISK_FUNCTION_NAME' => 'ฟังก์ชันการเพิ่มข้อมูลฝั่งผู้ใช้แบบละเอียด',
                    'ACTIVE' => 'True',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('risk_function');
    }
}
