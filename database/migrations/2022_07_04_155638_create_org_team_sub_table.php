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
        if (!Schema::hasTable('org_team_sub'))
        {
            Schema::create('org_team_sub', function (Blueprint $table) {
                $table->bigIncrements('org_team_sub_id');  
                $table->string('org_team_id',255)->nullable();//ชื่อทีม
                $table->string('user_id',255)->nullable();//   
                $table->string('user_position_id',255)->nullable();//        
                $table->string('user_position_team',255)->nullable();//    
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
        Schema::dropIfExists('org_team_sub');
    }
};
