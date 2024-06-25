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
        if (!Schema::hasTable('checkauthen_type'))
        {
            Schema::connection('mysql')->create('checkauthen_type', function (Blueprint $table) {
                $table->bigIncrements('checkauthen_type_id');
                $table->string('checkauthen_type_code')->nullable();// 
                $table->string('checkauthen_type_name')->nullable();// 
                $table->enum('active', ['TRUE','FALSE'])->default('TRUE')->nullable();
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
        Schema::dropIfExists('checkauthen_type');
    }
};
