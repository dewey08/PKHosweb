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
        if (!Schema::hasTable('building_room_type'))
        {
        Schema::create('building_room_type', function (Blueprint $table) {
            $table->bigIncrements('room_type_id');  
            $table->string('room_type_name')->nullable();// ชื่อสี
            $table->timestamps();
            });

            if (Schema::hasTable('building_room_type')) {
                DB::table('building_room_type')->truncate();
            }
            DB::table('building_room_type')->insert(array(
                'room_type_id' => '1',
                'room_type_name' => 'ห้องทั่วไป',        
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('building_room_type')->insert(array(
                'room_type_id' => '2',
                'room_type_name' => 'ห้องรับรอง',          
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('building_room_type')->insert(array(
                'room_type_id' => '3',
                'room_type_name' => 'ห้องประชุม',          
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('building_room_type')->insert(array(
                'room_type_id' => '4',
                'room_type_name' => 'ห้องพิเศษ1',          
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('building_room_type')->insert(array(
                'room_type_id' => '5',
                'room_type_name' => 'ห้องพิเศษ2',          
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('building_room_type')->insert(array(
                'room_type_id' => '6',
                'room_type_name' => 'ห้องพิเศษ3',          
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('building_room_type')->insert(array(
                'room_type_id' => '7',
                'room_type_name' => 'ห้องพิเศษ4',          
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('building_room_type')->insert(array(
                'room_type_id' => '8',
                'room_type_name' => 'ห้องพิเศษ5',          
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('building_room_type')->insert(array(
                'room_type_id' => '9',
                'room_type_name' => 'ห้องส่วนตัว',          
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
        Schema::dropIfExists('building_room_type');
    }
};
