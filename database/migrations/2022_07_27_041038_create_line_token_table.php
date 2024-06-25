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
        if (!Schema::hasTable('line_token'))
        {
            Schema::create('line_token', function (Blueprint $table) {
                $table->bigIncrements('line_token_id');                
                $table->string('line_token_name',255)->nullable();// 
                $table->string('line_token_code',255)->nullable();//   
                $table->timestamps();
            }); 
            
            // if (Schema::hasTable('line_token')) {
            //     DB::table('line_token')->truncate();
            // }
            DB::table('line_token')->insert(array(
                'line_token_id' => '1',
                'line_token_name' => 'ระบบลา',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('line_token')->insert(array(
                'line_token_id' => '2',
                'line_token_name' => 'ระบบสารบรรณ',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('line_token')->insert(array(
                'line_token_id' => '3',
                'line_token_name' => 'ระบบยานพาหนะ',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('line_token')->insert(array(
                'line_token_id' => '4',
                'line_token_name' => 'ระบบห้องประชุม',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('line_token')->insert(array(
                'line_token_id' => '5',
                'line_token_name' => 'ศูนย์ซ่อมบำรุง',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('line_token')->insert(array(
                'line_token_id' => '6',
                'line_token_name' => 'ศูนย์คอมพิวเตอร์',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('line_token')->insert(array(
                'line_token_id' => '7',
                'line_token_name' => 'ศูนย์เครื่องมือแพทย์',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('line_token')->insert(array(
                'line_token_id' => '8',
                'line_token_name' => 'บ้านพัก',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('line_token')->insert(array(
                'line_token_id' => '9',
                'line_token_name' => 'แผนงาน',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('line_token')->insert(array(
                'line_token_id' => '10',
                'line_token_name' => 'พัสดุ',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('line_token')->insert(array(
                'line_token_id' => '11',
                'line_token_name' => 'คลังวัสดุ',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('line_token')->insert(array(
                'line_token_id' => '12',
                'line_token_name' => 'คลังยา',           
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
        Schema::dropIfExists('line_token');
    }
};
