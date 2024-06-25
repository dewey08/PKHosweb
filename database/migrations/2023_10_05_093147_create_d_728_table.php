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
        if (!Schema::hasTable('d_728'))
        {
            Schema::connection('mysql')->create('d_728', function (Blueprint $table) { 
                $table->bigIncrements('d_728_id');//  
                $table->string('NHSO_ADP_Code')->nullable();//   
                $table->string('NHSO_ADP_Type_ID')->nullable();//  
                $table->string('NHSO_ADP_Code_Name')->nullable();//  
                $table->string('UCEP')->nullable();//   
                $table->enum('active', ['N','Y'])->default('Y')->nullable(); 
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
        Schema::dropIfExists('d_728');
    }
};
