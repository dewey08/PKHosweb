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
        if (!Schema::hasTable('air_list'))
        {
            Schema::create('air_list', function (Blueprint $table) {
                $table->bigIncrements('air_list_id'); 
                $table->char('air_list_num', length: 200)->nullable();  //           
                $table->char('air_list_name', length: 200)->nullable(); //  
                $table->char('detail', length: 200)->nullable(); //  
                $table->char('bran_id', length: 200)->nullable(); //  
                $table->char('brand_name', length: 200)->nullable(); //  
                $table->char('btu', length: 200)->nullable(); //
                $table->char('serial_no', length: 200)->nullable(); //
                $table->char('air_location_id', length: 200)->nullable(); //   
                $table->char('air_location_name', length: 200)->nullable();  //  
                $table->decimal('air_price',total: 12, places: 2)->nullable(); // 
                $table->char('air_room_class', length: 200)->nullable(); // 
                $table->char('air_year', length: 200)->nullable(); // 
                $table->binary('air_img')->nullable(); //                 
                $table->char('air_imgname', length: 200)->nullable(); //
                $table->longText('air_img_base')->nullable(); // 
                $table->date('air_recive_date')->nullable();  // 

                $table->enum('active', ['N','R','Y','D'])->default('Y');
                $table->enum('air_edit', ['Chang','Repaire','Dispose','Narmal'])->default('Narmal');
                $table->enum('air_backup', ['Y','N'])->default('N');
                $table->date('air_date_pdd')->nullable();  // วันที่ผลิต
                $table->date('air_date_exp')->nullable();  // วันหมดอายุ
                $table->char('air_for_check', length: 200)->nullable(); //   
                $table->char('user_id', length: 200)->nullable(); //   
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('air_list');
    }
};
