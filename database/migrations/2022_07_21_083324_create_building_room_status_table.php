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
        if (!Schema::hasTable('building_room_status'))
        {
        Schema::create('building_room_status', function (Blueprint $table) {
            $table->bigIncrements('room_status_id');  
            $table->string('room_status_name')->nullable();// ชื่อสี
            $table->timestamps();
            });

            // if (Schema::hasTable('building_room_status')) {
            //     DB::table('building_room_status')->truncate();
            // }
            DB::table('building_room_status')->insert(array(
                'room_status_id' => '1',
                'room_status_name' => 'ใช้งานปกติ',        
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('building_room_status')->insert(array(
                'room_status_id' => '2',
                'room_status_name' => 'ปิดปรับปรุง',          
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('building_room_status')->insert(array(
                'room_status_id' => '3',
                'room_status_name' => 'ปิด',          
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
        Schema::dropIfExists('building_room_status');
    }
};
