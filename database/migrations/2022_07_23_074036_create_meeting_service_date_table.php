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
        if (!Schema::hasTable('meeting_service_date'))
        {
            Schema::create('meeting_service_date', function (Blueprint $table) {
                $table->bigIncrements('meeting_service_date_id');
                $table->string('meeting_id')->nullable();//              
                $table->date('meeting_date_begin')->nullable();//ตั้งแต่วันที่
                // $table->date('meeting_date_end')->nullable();//ถึงวันที่
                $table->time('meeting_time_begin')->nullable();//ตั้งแต่เวลา
                $table->time('meeting_time_end')->nullable();//ถึงเวลา 
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
        Schema::dropIfExists('meeting_service_date');
    }
};
