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
        if (!Schema::hasTable('article_status'))
        {
            Schema::create('article_status', function (Blueprint $table) {
                $table->bigIncrements('article_status_id'); 
                $table->string('article_status_code',255)->nullable();// 
                $table->string('article_status_name',255)->nullable();//สถานะ   
                $table->timestamps();
            }); 
            
            if (Schema::hasTable('article_status')) {
                DB::table('article_status')->truncate();
            }
            DB::table('article_status')->insert(array(
                'article_status_id' => '1',
                'article_status_name' => 'ยืม',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('article_status')->insert(array(
                'article_status_id' => '2',
                'article_status_name' => 'ส่งซ่อม',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('article_status')->insert(array(
                'article_status_id' => '3',
                'article_status_name' => 'ปกติ',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('article_status')->insert(array(
                'article_status_id' => '4',
                'article_status_name' => 'ระหว่างซ่อม',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('article_status')->insert(array(
                'article_status_id' => '5',
                'article_status_name' => 'รอจำหน่าย',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('article_status')->insert(array(
                'article_status_id' => '6',
                'article_status_name' => 'จำหน่าย',           
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
        Schema::dropIfExists('article_status');
    }
};
