<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseFunctionlistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if(!Schema::hasTable('warehouse_functionlist')){ 
            Schema::create('warehouse_functionlist', function (Blueprint $table) {

                $table->id("WAREHOUSE_FUNCTION_ID",11); 
                $table->String("WAREHOUSE_FUNCTION_NAME",255)->nullable();              
                $table->enum('ACTIVE', ['True', 'False'])->default('False');  
                $table->dateTime('updated_at');
                $table->dateTime('created_at');

            });

        
            DB::table('warehouse_functionlist')->insert(array(
                'WAREHOUSE_FUNCTION_ID' => '1',
                'WAREHOUSE_FUNCTION_NAME' => 'ปิดการใช้งานการเพิ่มลดรายการเบิก',
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
        Schema::dropIfExists('warehouse_functionlist');
    }
}
