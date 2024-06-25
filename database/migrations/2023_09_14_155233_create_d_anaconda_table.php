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
        if (!Schema::hasTable('d_anaconda'))
        {
            Schema::connection('mysql')->create('d_anaconda', function (Blueprint $table) { 
                $table->bigIncrements('d_anaconda_id');//  
                $table->string('name')->nullable();//   
                $table->string('detail')->nullable();//  
                $table->string('name_shot')->nullable();//  
                $table->date('date')->nullable();//  
                $table->string('category')->nullable();//
                $table->string('user_id')->nullable();//
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
        Schema::dropIfExists('d_anaconda');
    }
};
