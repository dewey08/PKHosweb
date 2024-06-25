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
        if (!Schema::hasTable('acc_doc'))
        {
            Schema::connection('mysql')->create('acc_doc', function (Blueprint $table) {
                $table->bigIncrements('acc_doc_id');
                $table->string('acc_doc_pang')->nullable();//
                $table->string('acc_doc_pangid')->nullable();//
                $table->binary('file')->nullable();// 
                $table->string('filename')->nullable();// 
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
        Schema::dropIfExists('acc_doc');
    }
};
