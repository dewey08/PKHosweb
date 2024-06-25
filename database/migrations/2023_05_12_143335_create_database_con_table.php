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
        if (!Schema::hasTable('database_con'))
        {
        Schema::create('database_con', function (Blueprint $table) {
            $table->bigIncrements('database_con_id');  
            $table->string('DB_HOST',100)->nullable();// 
            $table->string('DB_DATABASE',100)->nullable();// 
            $table->string('DB_USERNAME',100)->nullable();//  
            $table->string('DB_PASSWORD',255)->nullable();// 
            $table->string('DB_PORT',100)->nullable();//  
            $table->string('APP_API',100)->nullable();// 
            $table->string('APP_DATACENTER',100)->nullable();// 
            $table->string('userid',255)->nullable();// 
            $table->string('store_id',255)->nullable();// 
            $table->Date('vstdate')->nullable();//  
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
        Schema::dropIfExists('database_con');
    }
};
