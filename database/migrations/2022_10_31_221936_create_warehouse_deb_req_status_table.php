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
        if (!Schema::hasTable('warehouse_deb_req_status'))
        {
        Schema::create('warehouse_deb_req_status', function (Blueprint $table) {
            $table->bigIncrements('warehouse_deb_req_status_id'); 
            $table->string('warehouse_deb_req_status_code',255)->nullable();// 
            $table->string('warehouse_deb_req_status_name',255)->nullable();// 
            $table->timestamps();
        }); 
         
        DB::table('warehouse_deb_req_status')->insert(array(
            'warehouse_deb_req_status_id' => '1',
            'warehouse_deb_req_status_code' => 'request',
            'warehouse_deb_req_status_name' => 'ร้องขอ',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('warehouse_deb_req_status')->insert(array(
            'warehouse_deb_req_status_id' => '2',
            'warehouse_deb_req_status_code' => 'allow',
            'warehouse_deb_req_status_name' => 'อนุญาต',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));   
       
        DB::table('warehouse_deb_req_status')->insert(array(
            'warehouse_deb_req_status_id' => '3',
            'warehouse_deb_req_status_code' => 'approve',
            'warehouse_deb_req_status_name' => 'อนุมัติ',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        // DB::table('warehouse_deb_req_status')->insert(array(
        //     'warehouse_deb_req_status_id' => '4',
        //     'warehouse_deb_req_status_code' => 'sendout',
        //     'warehouse_deb_req_status_name' => 'ส่งซ่อมนอก',          
        //     'created_at' => date('Y-m-d H:i:s'),
        //     'updated_at' => date('Y-m-d H:i:s'),
        // )); 
     
         
    }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouse_deb_req_status');
    }
};
