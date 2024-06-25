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
        if (!Schema::hasTable('medical_store_night'))
        {
            Schema::connection('mysql')->create('medical_store_night', function (Blueprint $table) {
                $table->bigIncrements('medical_store_night_id'); 
                $table->string('year',100)->nullable();//
                $table->date('date_borrow')->nullable();//
                $table->Time('time_borrow')->nullable();// 
                $table->string('medical_typecat_id')->nullable();//ประเภทเครื่องมือ หรือชื่อคลัง        
                $table->string('debsubsub_from')->nullable();//จากหน่วยงาน
                $table->string('debsubsub_borrow')->nullable();// หน่วยงานที่ยืม                
                $table->string('lender')->nullable();//ผู้ให้ยืม
                $table->string('borrower')->nullable();// ผู้ยืม 
                $table->enum('active', ['REQUEST','APPROVE','CANCEL','SENDEB','FINISH'])->default('REQUEST')->nullable();
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
        Schema::dropIfExists('medical_store_night');
    }
};
