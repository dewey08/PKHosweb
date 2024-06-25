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
        if (!Schema::hasTable('visit_pttype_token_authen'))
        {
        Schema::create('visit_pttype_token_authen', function (Blueprint $table) {
            $table->bigIncrements('visit_pttype_token_authen_id');  
                $table->string('cid')->nullable();// 
                $table->string('token')->nullable();//              
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
        Schema::dropIfExists('visit_pttype_token_authen');
    }
};
