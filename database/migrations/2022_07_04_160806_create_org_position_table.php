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
        if (!Schema::hasTable('org_position'))
        {
        Schema::create('org_position', function (Blueprint $table) {
            $table->bigIncrements('org_position_id');  
            $table->string('org_position_name',255)->nullable();//ชื่อ    
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
        Schema::dropIfExists('org_position');
    }
};
