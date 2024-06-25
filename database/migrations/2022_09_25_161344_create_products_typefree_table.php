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
        if (!Schema::hasTable('products_typefree'))
        {
            Schema::create('products_typefree', function (Blueprint $table) {
                $table->bigIncrements('products_typefree_id');  
                $table->string('products_typefree_name',255)->nullable();//    
                $table->timestamps();
            }); 
            
            // if (Schema::hasTable('products_typefree')) {
            //     DB::table('products_typefree')->truncate();
            // }
            DB::table('products_typefree')->insert(array(
                'products_typefree_id' => '1', 
                'products_typefree_name' => 'รายการปกติ',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('products_typefree')->insert(array(
                'products_typefree_id' => '2', 
                'products_typefree_name' => 'ยอดยกมา',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('products_typefree')->insert(array(
                'products_typefree_id' => '3', 
                'products_typefree_name' => 'ของแถม',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('products_typefree')->insert(array(
                'products_typefree_id' => '4', 
                'products_typefree_name' => 'บริจาค',           
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
        Schema::dropIfExists('products_typefree');
    }
};
