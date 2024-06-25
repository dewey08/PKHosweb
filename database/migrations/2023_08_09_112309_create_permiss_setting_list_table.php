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
        if (!Schema::hasTable('permiss_setting_list'))
        {
            Schema::connection('mysql')->create('permiss_setting_list', function (Blueprint $table) {
                $table->bigIncrements('permiss_setting_list_id');  
                $table->string('permiss_setting_list_name')->nullable();//  
                $table->enum('active', ['TRUE','FALSE'])->default('TRUE')->nullable();
                $table->timestamps();
            });
            // DB::table('permiss_setting_list')->insert(array(
            //     'permiss_setting_list_id' => '1', 
            //     'permiss_setting_list_name' => 'SET_ENV',        
            //     'created_at' => date('Y-m-d H:i:s'),
            //     'updated_at' => date('Y-m-d H:i:s'),
            // ));
            // DB::table('permiss_setting_list')->insert(array(
            //     'permiss_setting_list_id' => '2', 
            //     'permiss_setting_list_name' => 'SET_WAREHOUSE',          
            //     'created_at' => date('Y-m-d H:i:s'),
            //     'updated_at' => date('Y-m-d H:i:s'),
            // ));   
           
            // DB::table('permiss_setting_list')->insert(array(
            //     'permiss_setting_list_id' => '3', 
            //     'permiss_setting_list_name' => 'SET_ACCOUNT',          
            //     'created_at' => date('Y-m-d H:i:s'),
            //     'updated_at' => date('Y-m-d H:i:s'),
            // )); 
            // DB::table('permiss_setting_list')->insert(array(
            //     'permiss_setting_list_id' => '4', 
            //     'permiss_setting_list_name' => 'SET_UCS',          
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
        Schema::dropIfExists('permiss_setting_list');
    }
};
