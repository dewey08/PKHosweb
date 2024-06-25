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
 
        if (!Schema::hasTable('book_type'))
        {
        Schema::create('book_type', function (Blueprint $table) {
            $table->bigIncrements('booktype_id'); 
            $table->string('booktype_name',255)->nullable();//ชั้นความลับ     
            $table->timestamps();
        }); 
        
        if (Schema::hasTable('book_type')) {
            DB::table('book_type')->truncate();
        }
        DB::table('book_type')->insert(array(
            'booktype_id' => '1',
            'booktype_name' => 'หนังสือภายนอก',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('book_type')->insert(array(
            'booktype_id' => '2',
            'booktype_name' => 'หนังสือภายใน',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));   
        DB::table('book_type')->insert(array(
            'booktype_id' => '3',
            'booktype_name' => 'หนังสือประทับตรา',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('book_type')->insert(array(
            'booktype_id' => '4',
            'booktype_name' => 'หนังสือสั่งการ',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('book_type')->insert(array(
            'booktype_id' => '5',
            'booktype_name' => 'หนังสือประชาสัมพันธ์',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('book_type')->insert(array(
            'booktype_id' => '6',
            'booktype_name' => 'หนังสือที่เจ้าหน้าที่ทำขึ้นหรือรับไว้เป็นหลักฐานในราชการ',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('book_type')->insert(array(
            'booktype_id' => '7',
            'booktype_name' => 'หนังสือวิทยุ',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('book_type')->insert(array(
            'booktype_id' => '8',
            'booktype_name' => 'หนังสือขอประวัติการรักษาพยาบาล',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('book_type')->insert(array(
            'booktype_id' => '9',
            'booktype_name' => 'หนังสือคำสั่ง',          
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
        Schema::dropIfExists('book_type');
    }
};
