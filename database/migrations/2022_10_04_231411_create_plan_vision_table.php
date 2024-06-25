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
        if (!Schema::hasTable('plan_vision'))
        {
            Schema::create('plan_vision', function (Blueprint $table) {
                $table->bigIncrements('plan_vision_id');  
                $table->string('plan_vision_no',255)->nullable();//  
                $table->string('plan_vision_name',255)->nullable();//    
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
        Schema::dropIfExists('plan_vision');
    }
};
