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
        if (!Schema::hasTable('ot_price'))
        {
        Schema::create('ot_price', function (Blueprint $table) {
            $table->bigIncrements('ot_price_id');   
            $table->string('ot_pricename')->nullable();//    
            $table->double('ot_price_lete', 10, 2)->nullable();//ราคา
            $table->enum('ot_price_active', ['TRUE','FALSE'])->default('TRUE')->nullable();
            $table->timestamps();
        });

        if (Schema::hasTable('ot_price')) {
            DB::table('ot_price')->truncate();
        }
        DB::table('ot_price')->insert(array(
            'ot_price_id' => '1', 
            'ot_pricename' => 'พนักงานประจำ1',  
            'ot_price_lete' => '50',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('ot_price')->insert(array(
            'ot_price_id' => '2', 
            'ot_pricename' => 'พนักงานประจำ2',  
            'ot_price_lete' => '60',       
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('ot_price')->insert(array(
            'ot_price_id' => '3', 
            'ot_pricename' => 'ลูกจ้าง1',  
            'ot_price_lete' => '48',       
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('ot_price')->insert(array(
            'ot_price_id' => '4', 
            'ot_pricename' => 'ลูกจ้าง2',  
            'ot_price_lete' => '57',       
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('ot_price')->insert(array(
            'ot_price_id' => '5', 
            'ot_pricename' => 'ลูกจ้าง3',  
            'ot_price_lete' => '87.5',       
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
        Schema::dropIfExists('ot_price');
    }
};
