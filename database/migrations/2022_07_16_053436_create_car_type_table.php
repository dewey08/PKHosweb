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
        if (!Schema::hasTable('car_type'))
        {
            Schema::create('car_type', function (Blueprint $table) {
                $table->bigIncrements('car_type_id'); 
                $table->string('car_type_code',255)->nullable();// 
                $table->string('car_type_name',255)->nullable();//สถานะ   
                $table->timestamps();
            }); 
            
            if (Schema::hasTable('car_type')) {
                DB::table('car_type')->truncate();
            }
            DB::table('car_type')->insert(array(
                'car_type_id' => '1',
                'car_type_name' => 'รถยนต์นั่งส่วนบุคคลเกิน 7 คน',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('car_type')->insert(array(
                'car_type_id' => '2',
                'car_type_name' => 'รถพยาบาล',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('car_type')->insert(array(
                'car_type_id' => '3',
                'car_type_name' => 'รถยนต์บรรทุก',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('car_type')->insert(array(
                'car_type_id' => '4',
                'car_type_name' => 'รถยนต์ลากจูง',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('car_type')->insert(array(
                'car_type_id' => '5',
                'car_type_name' => 'รถพ่วง',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('car_type')->insert(array(
                'car_type_id' => '6',
                'car_type_name' => 'รถจักรยานยนต์',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('car_type')->insert(array(
                'car_type_id' => '7',
                'car_type_name' => 'รถยนต์นั่งรับจ้าง(ไม่เกิน 7 ที่นั่ง)',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('car_type')->insert(array(
                'car_type_id' => '8',
                'car_type_name' => 'อื่นๆ',           
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
        Schema::dropIfExists('car_type');
    }
};
