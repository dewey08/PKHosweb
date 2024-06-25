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
        if (!Schema::hasTable('p4p_workgroupset_unit'))
        {
        Schema::create('p4p_workgroupset_unit', function (Blueprint $table) {
            $table->bigIncrements('p4p_workgroupset_unit_id'); 
            $table->string('p4p_workgroupset_unit_name')->nullable();//   
            $table->enum('p4p_workgroupset_unit_active', ['TRUE','FALSE'])->default('TRUE')->nullable();
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
        Schema::dropIfExists('p4p_workgroupset_unit');
    }
};
