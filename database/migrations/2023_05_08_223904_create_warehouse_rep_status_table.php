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
        if (!Schema::hasTable('warehouse_rep_status'))
        {
        Schema::create('warehouse_rep_status', function (Blueprint $table) {
            $table->bigIncrements('warehouse_rep_status_id');       
            $table->string('status_code',100)->nullable();// 
            $table->string('status_name',255)->nullable();//  
            $table->enum('active', ['Y','N'])->default('Y')->nullable();
            $table->timestamps();
            });
        }
        if (Schema::hasTable('warehouse_rep_status')) {
            DB::table('warehouse_rep_status')->truncate();
        }
        DB::table('warehouse_rep_status')->insert(array(
            'warehouse_rep_status_id' => '1', 
            'status_code' => 'request',  
            'status_name' => 'ร้องขอ',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('warehouse_rep_status')->insert(array(
            'warehouse_rep_status_id' => '2', 
            'status_code' => 'recieve',  
            'status_name' => 'รับสินค้า',       
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('warehouse_rep_status')->insert(array(
            'warehouse_rep_status_id' => '3', 
            'status_code' => 'confirm',  
            'status_name' => 'ยืนยัน',       
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('warehouse_rep_status')->insert(array(
            'warehouse_rep_status_id' => '4', 
            'status_code' => 'savedata',  
            'status_name' => 'บันทึกข้อมูล',       
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('warehouse_rep_status')->insert(array(
            'warehouse_rep_status_id' => '5', 
            'status_code' => 'Cancel',  
            'status_name' => 'ยกเลิก',       
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('warehouse_rep_status')->insert(array(
            'warehouse_rep_status_id' => '6', 
            'status_code' => 'Confirm Cancel',  
            'status_name' => 'ยืนยันการยกเลิก',       
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouse_rep_status');
    }
};
