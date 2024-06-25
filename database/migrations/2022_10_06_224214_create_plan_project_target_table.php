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
        if (!Schema::hasTable('plan_project_target'))
        {
            Schema::create('plan_project_target', function (Blueprint $table) {
                $table->bigIncrements('plan_project_target_id'); 
                $table->string('plan_project_target_name',255)->nullable();// กลุ่มเป้าหมาย 
                $table->string('plan_project_id',255)->nullable();//แผน                
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
        Schema::dropIfExists('plan_project_target');
    }
};
