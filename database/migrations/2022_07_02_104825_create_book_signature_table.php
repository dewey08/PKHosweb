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
        if (!Schema::hasTable('book_signature'))
        {
        Schema::create('book_signature', function (Blueprint $table) {
            $table->bigIncrements('signature_id');   
            $table->string('user_id')->nullable();// 
            $table->string('bookrep_id')->nullable();// 
            $table->string('signature_name')->nullable();// 
            $table->text('signature_name_usertext')->nullable();//ผู้รองขอ
            $table->text('signature_name_hntext')->nullable();//หัวหน้า 
            $table->text('signature_name_grouptext')->nullable();//หัวหน้ากลุ่ม 
            $table->text('signature_name_text')->nullable();//หัวหน้าบริหาร 
            $table->text('signature_name_potext')->nullable();//ผอ
            $table->binary('signature_file')->nullable();// 
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
        Schema::dropIfExists('book_signature');
    }
};
