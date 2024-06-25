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
        if (!Schema::hasTable('com_repaire_speed'))
        {
        Schema::create('com_repaire_speed', function (Blueprint $table) {
            $table->bigIncrements('status_id');  
            $table->string('status_name')->nullable();// ชื่อสี
            $table->timestamps();
            });

          
            DB::table('com_repaire_speed')->insert(array(
                'status_id' => '1',
                'status_name' => 'ปกติ',        
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('com_repaire_speed')->insert(array(
                'status_id' => '2',
                'status_name' => 'ด่วน',          
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('com_repaire_speed')->insert(array(
                'status_id' => '3',
                'status_name' => 'ด่วนมาก',          
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('com_repaire_speed')->insert(array(
                'status_id' => '4',
                'status_name' => 'ด่วนที่สุด',          
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
        Schema::dropIfExists('com_repaire_speed');
    }
};
