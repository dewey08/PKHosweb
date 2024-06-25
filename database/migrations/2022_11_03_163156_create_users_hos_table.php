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
        if (!Schema::hasTable('users_hos'))
        {
        Schema::create('users_hos', function (Blueprint $table) {
            $table->bigIncrements('users_hos_id'); 
            $table->string('users_hos_code')->nullable();//          
            $table->string('users_hos_name',255)->nullable();//   
            $table->enum('users_hos_active', ['TRUE','FALSE'])->default('FALSE')->nullable();
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
        Schema::dropIfExists('users_hos');
    }
};
