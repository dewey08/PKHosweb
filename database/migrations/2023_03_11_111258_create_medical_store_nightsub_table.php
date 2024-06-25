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
        if (!Schema::hasTable('medical_store_nightsub'))
        {
            Schema::connection('mysql')->create('medical_store_nightsub', function (Blueprint $table) {
                $table->bigIncrements('medical_store_nightsub_id'); 
                $table->string('medical_store_night_id',100)->nullable();// 
                $table->date('date_borrow_go')->nullable();//วันที่ยืม
                $table->Time('time_borrow_go')->nullable();// เวลาที่ยืม
                $table->date('date_borrow_back')->nullable();//วันที่คืน
                $table->Time('time_borrow_back')->nullable();// เวลาที่คืน
                $table->string('article_id')->nullable();// 
                $table->string('article_unit_id')->nullable();//                  
                $table->string('qty')->nullable();//  
                $table->double('price', 12, 4)->nullable();//
                $table->double('total', 12, 4)->nullable();//
                $table->enum('active', ['BORROW','NIGHT','REPAIRE','NARMAL'])->default('NARMAL')->nullable(); //ยืม คืน ส่งซ่อม ปกติ
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
        Schema::dropIfExists('medical_store_nightsub');
    }
};
