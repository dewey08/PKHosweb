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
        if (!Schema::hasTable('medical_store_rep'))
        {
            Schema::connection('mysql')->create('medical_store_rep', function (Blueprint $table) {
                $table->bigIncrements('medical_store_rep_id'); 
                $table->string('year',100)->nullable();//
                $table->date('date_rep')->nullable();//
                $table->Time('time_rep')->nullable();// 
                $table->string('medical_typecat_id')->nullable();//ชื่อคลัง    
                $table->string('user_rep')->nullable();// ผู้รับเข้า 
                $table->string('total_qty')->nullable();//
                $table->double('total_price', 12, 4)->nullable();//
                $table->enum('active', ['REP','APPROVE','CANCEL','FINISH'])->default('REP')->nullable();
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
        Schema::dropIfExists('medical_store_rep');
    }
};
