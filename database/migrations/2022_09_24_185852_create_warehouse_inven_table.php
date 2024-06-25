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
        if (!Schema::hasTable('warehouse_inven'))
        {
        Schema::create('warehouse_inven', function (Blueprint $table) {
            $table->bigIncrements('warehouse_inven_id');    
            $table->text('warehouse_inven_name')->nullable();// 
            $table->string('warehouse_inven_userid')->nullable();//  
            $table->string('warehouse_inven_username')->nullable();// 
            $table->enum('warehouse_inven_active', ['TRUE', 'FALSE'])->default('TRUE');
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
        Schema::dropIfExists('warehouse_inven');
    }
};
