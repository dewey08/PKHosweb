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
        if (!Schema::hasTable('permiss_setting'))
        {
            Schema::connection('mysql')->create('permiss_setting', function (Blueprint $table) {
                $table->bigIncrements('permiss_setting_id'); 
                $table->string('permiss_setting_userid')->nullable();// 
                $table->string('permiss_setting_name')->nullable();//  
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
        Schema::dropIfExists('permiss_setting');
    }
};
