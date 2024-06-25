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
        if (!Schema::hasTable('speed_class'))
        {
        Schema::create('speed_class', function (Blueprint $table) {
            $table->bigIncrements('speed_class_id'); 
            $table->string('speed_class_name',255)->nullable();//ชั้นความเร็ว      
            $table->timestamps();
        }); 
        // if (Schema::hasTable('speed_class')) {
        //     DB::table('speed_class')->truncate();
        // }
        DB::table('speed_class')->insert(array(
            'speed_class_id' => '1',
            'speed_class_name' => 'ปกติ',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('speed_class')->insert(array(
            'speed_class_id' => '2',
            'speed_class_name' => 'ด่วน',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('speed_class')->insert(array(
            'speed_class_id' => '3',
            'speed_class_name' => 'ด่วนมาก',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('speed_class')->insert(array(
            'speed_class_id' => '4',
            'speed_class_name' => 'ด่วนมากที่สุด',          
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
        Schema::dropIfExists('speed_class');
    }
};
