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
        if (!Schema::hasTable('ssop_opdx'))
        {
            Schema::connection('mysql7')->create('ssop_opdx', function (Blueprint $table) {
                $table->bigIncrements('ssop_opdx_id'); 
                $table->string('Class')->nullable();//  
                $table->string('SvID')->nullable();//  
                $table->string('SL')->nullable();//  
                $table->string('CodeSet')->nullable();// 
                $table->string('code')->nullable();// 
                $table->string('Desc')->nullable();// 
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
        Schema::dropIfExists('ssop_opdx');
    }
};
