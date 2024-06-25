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
        if (!Schema::hasTable('org_team'))
        {
        Schema::create('org_team', function (Blueprint $table) {
            $table->bigIncrements('org_team_id');  
            $table->string('org_team_name',255)->nullable();//ชื่อทีม   
            $table->string('org_team_detail',255)->nullable();//รายละเอียด       
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
        Schema::dropIfExists('org_team');
    }
};
