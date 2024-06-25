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
        if (!Schema::hasTable('user_permisslist'))
        {
        Schema::create('user_permisslist', function (Blueprint $table) {
            $table->bigIncrements('user_permisslist_id');  
                $table->string('user_permisslist_name')->nullable();//   
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
        Schema::dropIfExists('user_permisslist');
    }
};
