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
        if (!Schema::hasTable('meeting_service_list'))
        {
            Schema::create('meeting_service_list', function (Blueprint $table) {
                $table->bigIncrements('meeting_service_list_id');
                $table->string('meeting_list_id')->nullable();//
                $table->string('meeting_list_name')->nullable();//
                $table->string('meeting_service_list_qty')->nullable();// 
                $table->string('meeting_id')->nullable();//
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
        Schema::dropIfExists('meeting_service_list');
    }
};
