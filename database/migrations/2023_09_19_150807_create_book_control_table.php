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
        if (!Schema::hasTable('book_control'))
        {
            Schema::connection('mysql')->create('book_control', function (Blueprint $table) { 
                $table->bigIncrements('book_control_id');//                 
                $table->string('bookno')->nullable();//  เลขที่หนังสือ  
                $table->date('datebook')->nullable();//  ลงวันที่
                $table->date('daterep')->nullable();//  วันรับหนังสือ
                $table->text('bookname')->nullable();//  เรื่อง
                $table->string('department_from')->nullable();// จากหน่วยงาน  
                $table->string('user_id')->nullable();//ผู้รับ
                $table->text('comment')->nullable();//  หมายเหตุ
                $table->enum('active', ['TRUE','FALSE'])->default('TRUE')->nullable(); //สถานะ
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
        Schema::dropIfExists('book_control');
    }
};
