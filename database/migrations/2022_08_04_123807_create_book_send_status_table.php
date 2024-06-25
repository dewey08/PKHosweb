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
        if (!Schema::hasTable('book_send_status'))
        {
        Schema::create('book_send_status', function (Blueprint $table) {
            $table->bigIncrements('booksend_status_id'); 
            $table->string('booksend_status_code',255)->nullable();// 
            $table->string('booksend_status_name',255)->nullable();// 
            $table->timestamps();
        }); 
        
        // if (Schema::hasTable('book_send_status')) {
        //     DB::table('book_send_status')->truncate();
        // }
        DB::table('book_send_status')->insert(array(
            'booksend_status_id' => '1',
            'booksend_status_code' => 'receive',
            'booksend_status_name' => 'ลงรับ',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('book_send_status')->insert(array(
            'booksend_status_id' => '2',
            'booksend_status_code' => 'senddep',
            'booksend_status_name' => 'ส่งหน่วยงาน',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));   
       
        DB::table('book_send_status')->insert(array(
            'booksend_status_id' => '3',
            'booksend_status_code' => 'waitsend',
            'booksend_status_name' => 'รอดำเนินการ',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('book_send_status')->insert(array(
            'booksend_status_id' => '4',
            'booksend_status_code' => 'waitretire',
            'booksend_status_name' => 'รอเกษียณ',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('book_send_status')->insert(array(
            'booksend_status_id' => '5',
            'booksend_status_code' => 'retire',
            'booksend_status_name' => 'เกษียณ',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('book_send_status')->insert(array(
            'booksend_status_id' => '6',
            'booksend_status_code' => 'waitallows',
            'booksend_status_name' => 'รออนุมัติ',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('book_send_status')->insert(array(
            'booksend_status_id' => '7',
            'booksend_status_code' => 'allows',
            'booksend_status_name' => 'ผอ.อนุมัติ',          
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
        Schema::dropIfExists('book_send_status');
    }
};
