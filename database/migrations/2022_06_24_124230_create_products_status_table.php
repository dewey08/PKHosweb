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
        if (!Schema::hasTable('products_status'))
        {
        Schema::create('products_status', function (Blueprint $table) {
            $table->bigIncrements('products_status_id');
            $table->string('products_status_code')->nullable();//
            $table->string('products_status_name')->nullable();// 
            $table->enum('products_status_active', ['True', 'False'])->default('True');
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
        Schema::dropIfExists('products_status');
    }
};
