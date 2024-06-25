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
        if (!Schema::hasTable('medical_store_repsub'))
        {
            Schema::connection('mysql')->create('medical_store_repsub', function (Blueprint $table) {
                $table->bigIncrements('medical_store_repsub_id'); 
                $table->string('medical_store_rep_id',100)->nullable();//  
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
        Schema::dropIfExists('medical_store_repsub');
    }
};
