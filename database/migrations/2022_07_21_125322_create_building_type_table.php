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
        if (!Schema::hasTable('building_type'))
        {
        Schema::create('building_type', function (Blueprint $table) {
            $table->bigIncrements('building_type_id');  
            $table->string('building_type_name')->nullable();// ชื่อสี
            $table->timestamps();
            });

            if (Schema::hasTable('building_type')) {
                DB::table('building_type')->truncate();
            }
            DB::table('building_type')->insert(array(
                'building_type_id' => '1',
                'building_type_name' => 'อาคาร',        
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('building_type')->insert(array(
                'building_type_id' => '2',
                'building_type_name' => 'แฟลต',          
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('building_type')->insert(array(
                'building_type_id' => '3',
                'building_type_name' => 'บ้านพัก',          
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('building_type')->insert(array(
                'building_type_id' => '4',
                'building_type_name' => 'บ้านแฝด',          
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('building_type')->insert(array(
                'building_type_id' => '5',
                'building_type_name' => 'อื่นฯ',          
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
        Schema::dropIfExists('building_type');
    }
};
