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
        if (!Schema::hasTable('car_status'))
        {
        Schema::create('car_status', function (Blueprint $table) {
            $table->bigIncrements('car_status_id'); 
            $table->string('car_status_code',255)->nullable();// 
            $table->string('car_status_name',255)->nullable();//สถานะ   
            $table->timestamps();
        }); 
        
        if (Schema::hasTable('car_status')) {
            DB::table('car_status')->truncate();
        }
        DB::table('car_status')->insert(array(
            'car_status_id' => '1',
            'car_status_code' => 'request',
            'car_status_name' => 'ร้องขอ',           
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('car_status')->insert(array(
            'car_status_id' => '2',
            'car_status_code' => 'allocate',
            'car_status_name' => 'จัดสรร',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('car_status')->insert(array(
            'car_status_id' => '3',
            'car_status_code' => 'allocateall',
            'car_status_name' => 'จัดสรรร่วม',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));   
        DB::table('car_status')->insert(array(
            'car_status_id' => '4',
            'car_status_code' => 'cancel',
            'car_status_name' => 'ยกเลิก',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('car_status')->insert(array(
            'car_status_id' => '5',
            'car_status_code' => 'allow',
            'car_status_name' => 'อนุมัติ',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('car_status')->insert(array(
            'car_status_id' => '6',
            'car_status_code' => 'noallow',
            'car_status_name' => 'ไม่อนุมัติ',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('car_status')->insert(array(
            'car_status_id' => '7',
            'car_status_code' => 'confirmcancel',
            'car_status_name' => 'ยกเลิก',          
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
        Schema::dropIfExists('car_status');
    }
};
