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
        if (!Schema::hasTable('leave_year'))
        {
            Schema::connection('mysql')->create('leave_year', function (Blueprint $table) { 
                $table->bigIncrements('leave_year_id');//    
                $table->string('year')->nullable();//     
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
        Schema::dropIfExists('leave_year');
    }
};
