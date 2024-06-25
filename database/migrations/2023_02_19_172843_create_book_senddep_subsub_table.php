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
        if (!Schema::hasTable('book_senddep_subsub'))
        {
        Schema::create('book_senddep_subsub', function (Blueprint $table) {
            $table->bigIncrements('senddepsubsub_id'); 
            $table->string('bookrep_id',100)->nullable();//
            $table->string('senddep_depsubsub_id')->nullable();// 
            $table->string('senddep_depsubsub_name',255)->nullable();//         
            $table->date('senddep_date')->nullable();//
            $table->Time('senddep_time')->nullable();//      
            $table->string('senddepsub_usersend_id',255)->nullable();//ผู้ส่ง 
            $table->string('senddepsub_usersend_name',255)->nullable();//ผู้ส่ง 
            $table->string('objective_id',255)->nullable();//วัตถุประสงค์ 
            $table->string('objective_name',255)->nullable();//วัตถุประสงค์ 
            $table->enum('status_read', ['OPEN','CLOSE'])->default('CLOSE');
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
        Schema::dropIfExists('book_senddep_subsub');
    }
};
