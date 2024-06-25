<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        if (!Schema::hasTable('com_repaire_status'))
        {
        Schema::create('com_repaire_status', function (Blueprint $table) {
            $table->bigIncrements('com_repaire_status_id'); 
            $table->string('com_repaire_status_code',255)->nullable();// 
            $table->string('com_repaire_status_name',255)->nullable();// 
            $table->timestamps();
        }); 
         
        DB::table('com_repaire_status')->insert(array(
            'com_repaire_status_id' => '1',
            'com_repaire_status_code' => 'notifyrepair',
            'com_repaire_status_name' => 'แจ้งซ่อม',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('com_repaire_status')->insert(array(
            'com_repaire_status_id' => '2',
            'com_repaire_status_code' => 'carry_out',
            'com_repaire_status_name' => 'ดำเนินการ',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));   
       
        DB::table('com_repaire_status')->insert(array(
            'com_repaire_status_id' => '3',
            'com_repaire_status_code' => 'waiting',
            'com_repaire_status_name' => 'รออะไหล่',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('com_repaire_status')->insert(array(
            'com_repaire_status_id' => '4',
            'com_repaire_status_code' => 'sendout',
            'com_repaire_status_name' => 'ส่งซ่อมนอก',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('com_repaire_status')->insert(array(
            'com_repaire_status_id' => '5',
            'com_repaire_status_code' => 'finish',
            'com_repaire_status_name' => 'ซ่อมเสร็จ',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('com_repaire_status')->insert(array(
            'com_repaire_status_id' => '6',
            'com_repaire_status_code' => 'cancel',
            'com_repaire_status_name' => 'แจ้งยกเลิก',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('com_repaire_status')->insert(array(
            'com_repaire_status_id' => '7',
            'com_repaire_status_code' => 'confirmcancel',
            'com_repaire_status_name' => 'ยกเลิก',          
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
        Schema::dropIfExists('com_repaire_status');
    }
};
