<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleCarUpload extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {       
        if (!Schema::hasTable('vehicle_car_upload'))
        {
                Schema::create('vehicle_car_upload', function (Blueprint $table) {
                    $table->id("PDF_FILEID",11);
                    $table->String("PDF_FILENAME",255)->nullable(); 
                    $table->String("file_pdf")->nullable(); 
                    $table->binary("file_img")->nullable(); 
                    $table->enum('PDF_FILE_STATUS', ['True', 'False']);   
                    $table->dateTime('updated_at')->nullable();
                    $table->dateTime('created_at')->nullable();
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
        Schema::dropIfExists('vehicle_car_upload');
    }
}
