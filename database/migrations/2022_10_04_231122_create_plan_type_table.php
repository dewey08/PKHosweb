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
        if (!Schema::hasTable('plan_type'))
        {
            Schema::create('plan_type', function (Blueprint $table) {
                $table->bigIncrements('plan_type_id');  
                $table->string('plan_type_name',255)->nullable();//    
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
        Schema::dropIfExists('plan_type');
    }
};
