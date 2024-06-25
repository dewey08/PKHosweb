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
        if (!Schema::hasTable('warehouse_pay_status'))
        {
        Schema::create('warehouse_pay_status', function (Blueprint $table) {
            $table->bigIncrements('warehouse_pay_status_id'); 
            $table->string('warehouse_pay_status_code',255)->nullable();// 
            $table->string('warehouse_pay_status_name',255)->nullable();// 
            $table->timestamps();
        }); 
         
        DB::table('warehouse_pay_status')->insert(array(
            'warehouse_pay_status_id' => '1',
            'warehouse_pay_status_code' => 'pay',
            'warehouse_pay_status_name' => 'ทำเรื่องเบิกจ่าย',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('warehouse_pay_status')->insert(array(
            'warehouse_pay_status_id' => '2',
            'warehouse_pay_status_code' => 'confirm',
            'warehouse_pay_status_name' => 'ยืนยันการเบิกจ่าย',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));   
       
        DB::table('warehouse_pay_status')->insert(array(
            'warehouse_pay_status_id' => '3',
            'warehouse_pay_status_code' => 'cancel',
            'warehouse_pay_status_name' => 'ยกเลิก',          
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
        Schema::dropIfExists('warehouse_pay_status');
    }
};
