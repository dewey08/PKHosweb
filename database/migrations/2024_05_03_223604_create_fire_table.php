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
        if (!Schema::hasTable('fire'))
        {
            Schema::create('fire', function (Blueprint $table) {
                $table->bigIncrements('fire_id'); 
                $table->string('fire_num')->nullable();  //           
                $table->string('fire_name')->nullable(); //  
                $table->string('fire_size')->nullable(); //  
                $table->string('fire_color')->nullable(); //  
                $table->string('fire_location')->nullable(); //  
                $table->string('fire_qty')->nullable(); //
                $table->string('fire_unit')->nullable(); //
                $table->string('fire_comment')->nullable(); //   
                $table->binary('fire_img')->nullable(); //                 
                $table->string('fire_imgname')->nullable(); //
                $table->date('fire_date')->nullable();  // 
                $table->string('fire_year')->nullable();  //  
                $table->decimal('fire_price',total: 12, places: 2)->nullable(); // 
                $table->string('fire_brand')->nullable(); // 
                $table->enum('active', ['N','R','Y','D'])->default('Y');
                $table->longText('fire_img_base')->nullable(); //                 
                $table->string('fire_img_base_name')->nullable(); //
                $table->enum('fire_edit', ['Chang','Repaire','Dispose','Narmal'])->default('Narmal');
                $table->enum('fire_backup', ['Y','N'])->default('N');
                $table->date('fire_date_pdd')->nullable();  // วันที่ผลิต
                $table->date('fire_date_exp')->nullable();  // วันหมดอายุ
                $table->text('fire_for_nocheck')->nullable(); //   
                $table->timestamps();
            });
        }
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fire');
    }
};
