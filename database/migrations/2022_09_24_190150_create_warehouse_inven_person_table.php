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
        if (!Schema::hasTable('warehouse_inven_person'))
        {
        Schema::create('warehouse_inven_person', function (Blueprint $table) {
            $table->bigIncrements('warehouse_inven_person_id');    
            $table->text('warehouse_inven_id')->nullable();// 
            $table->text('warehouse_inven_person_userid')->nullable();//  
            $table->text('warehouse_inven_person_username')->nullable();//   
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
        Schema::dropIfExists('warehouse_inven_person_person');
    }
};
