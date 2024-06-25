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
        if (!Schema::hasTable('book_read'))
        {
        Schema::create('book_read', function (Blueprint $table) {
            $table->bigIncrements('book_read_id'); 
            $table->string('bookrep_id',100)->nullable();//
            $table->string('book_read_useropen_id')->nullable();//         
            $table->date('book_read_date')->nullable();//
            $table->Time('book_read_time')->nullable();// 
            
            $table->date('book_read_open_date')->nullable();//วันที่เปิดอ่าน
            $table->Time('book_read_open_time')->nullable();//  
            
            $table->enum('status_book_read', ['OPEN','CLOSE'])->default('CLOSE');
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_read');
    }
};
