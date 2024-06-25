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
        if (!Schema::hasTable('account_percen'))
        {
        Schema::create('account_percen', function (Blueprint $table) {
            $table->bigIncrements('account_percen_id'); 
            $table->string('account_percen_code')->nullable();//          
            $table->string('account_percen_name',255)->nullable();//   
            $table->string('account_percen_percent',255)->nullable();// 
            $table->enum('account_percen_active', ['TRUE','FALSE'])->default('FALSE')->nullable();
            $table->timestamps();
        });
        if (Schema::hasTable('account_percen')) {
            DB::table('account_percen')->truncate();
        }
        DB::table('account_percen')->insert(array(
            'account_percen_id' => '1',
            'account_percen_code' => ' ',
            'account_percen_name' => '1 %',           
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('account_percen')->insert(array(
            'account_percen_id' => '2',
            'account_percen_code' => ' ',
            'account_percen_name' => '2 %',           
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('account_percen')->insert(array(
            'account_percen_id' => '3',
            'account_percen_code' => ' ',
            'account_percen_name' => '3 %',           
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('account_percen')->insert(array(
            'account_percen_id' => '4',
            'account_percen_code' => ' ',
            'account_percen_name' => '4 %',           
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('account_percen')->insert(array(
            'account_percen_id' => '5',
            'account_percen_code' => ' ',
            'account_percen_name' => '5 %',           
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('account_percen')->insert(array(
            'account_percen_id' => '6',
            'account_percen_code' => ' ',
            'account_percen_name' => '6 %',           
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('account_percen')->insert(array(
            'account_percen_id' => '7',
            'account_percen_code' => ' ',
            'account_percen_name' => '7 %',           
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
        Schema::dropIfExists('account_percen');
    }
};
