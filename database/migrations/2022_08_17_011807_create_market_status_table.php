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
        if (!Schema::hasTable('market_status'))
        {
        Schema::create('market_status', function (Blueprint $table) {
            $table->bigIncrements('status_id');  
            $table->string('status_name')->nullable();// ชื่อสี
            $table->timestamps();
            });

          
            DB::table('market_status')->insert(array(
                'status_id' => '1',
                'status_name' => 'รับเข้าคลัง',        
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('market_status')->insert(array(
                'status_id' => '2',
                'status_name' => 'รอรับเข้าคลัง',          
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('market_status')->insert(array(
                'status_id' => '3',
                'status_name' => 'ยกเลิก',          
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('market_status')->insert(array(
                'status_id' => '4',
                'status_name' => 'ส่งคืน',          
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
        Schema::dropIfExists('market_status');
    }
};
