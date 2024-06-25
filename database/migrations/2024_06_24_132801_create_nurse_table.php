<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    { 
        if (!Schema::hasTable('nurse'))
        {
            Schema::create('nurse', function (Blueprint $table) {
                $table->bigIncrements('nurse_id'); 
                $table->date('datesave')->nullable();  //  
                $table->string('ward', length: 100)->nullable();  //  
                $table->string('ward_name', length: 100)->nullable();  //  
                $table->string('count_an', length: 200)->nullable();  // 

                $table->string('np_a', length: 200)->nullable();  // 
                $table->string('soot_a', length: 20)->nullable();  //  1.6
                $table->string('soot_a_sub', length: 20)->nullable();  //  8
                $table->string('soot_a_total', length: 255)->nullable();  //  = จำนวน nurse(A)
                
                $table->string('np_b', length: 200)->nullable();  //
                $table->string('soot_b', length: 20)->nullable();  //  1.6
                $table->string('soot_b_sub', length: 20)->nullable();  //  8
                $table->string('soot_b_total', length: 255)->nullable();  //  = จำนวน nurse(A)
                
                $table->string('np_c', length: 200)->nullable();  //
                $table->string('soot_c', length: 20)->nullable();  //  1.6
                $table->string('soot_c_sub', length: 20)->nullable();  //  8
                $table->string('soot_c_total', length: 255)->nullable();  //  = จำนวน nurse(A)
                
                       
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nurse');
    }
};
