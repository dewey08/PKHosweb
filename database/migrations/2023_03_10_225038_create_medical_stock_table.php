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
        if (!Schema::hasTable('medical_stock'))
        {
            Schema::connection('mysql')->create('medical_stock', function (Blueprint $table) {
                $table->bigIncrements('medical_stock_id');  
                $table->string('medical_typecat_id')->nullable();//ประเภทเครื่องมือ หรือชื่อคลัง 
                // $table->string('medical_typeborrownight')->nullable();//ยืม คืน
                $table->string('article_id')->nullable();// 
                $table->string('article_unit_id')->nullable();//  

                $table->string('qty')->nullable();// จำนวนที่รับเข้าคลัง                
                $table->string('qty_borrow')->nullable();// จำนวนที่ยืม
                $table->string('qty_night')->nullable();// จำนวนที่คืน
                $table->string('total_qty')->nullable();// จำนวนที่เหลือทั้งหมด

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
        Schema::dropIfExists('medical_stock');
    }
};
