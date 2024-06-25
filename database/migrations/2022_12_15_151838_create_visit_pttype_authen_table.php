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
        if (!Schema::hasTable('visit_pttype_authen'))
        {
        Schema::create('visit_pttype_authen', function (Blueprint $table) {
            $table->bigIncrements('visit_pttype_authen_id');  
                $table->string('visit_pttype_authen_cid')->nullable();// 
                $table->string('visit_pttype_authen_vn')->nullable();// 
                $table->string('visit_pttype_authen_hn')->nullable();// 
                $table->string('visit_pttype_authen_auth_code')->nullable();// 
                $table->string('visit_pttype_authen_fullname')->nullable();// 
                $table->string('visit_pttype_authen_department')->nullable();// 
                $table->string('visit_pttype_authen_staff')->nullable();// 
                $table->string('visit_pttype_authen_name')->nullable();// 
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
        Schema::dropIfExists('visit_pttype_authen');
    }
};
