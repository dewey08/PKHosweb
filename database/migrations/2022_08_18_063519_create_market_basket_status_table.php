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
        if (!Schema::hasTable('market_basket_status'))
        {
        Schema::create('market_basket_status', function (Blueprint $table) {
            $table->bigIncrements('status_id'); 
            $table->string('status_code',255)->nullable();// 
            $table->string('status_name',255)->nullable();// 
            $table->timestamps();
        }); 
        
        DB::table('market_basket_status')->insert(array(
            'status_id' => '1',
            'status_code' => 'narmalsale',
            'status_name' => 'ขายปกติ',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('market_basket_status')->insert(array(
            'status_id' => '2',
            'status_code' => 'finish',
            'status_name' => 'เสร็จเรียบร้อย',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));   
       
        DB::table('market_basket_status')->insert(array(
            'status_id' => '3',
            'status_code' => 'cancel',
            'status_name' => 'ยกเลิก',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('market_basket_status')->insert(array(
            'status_id' => '4',
            'status_code' => 'confirmcancel',
            'status_name' => 'ยืนยันการยกเลิก',          
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
        Schema::dropIfExists('market_basket_status');
    }
};
