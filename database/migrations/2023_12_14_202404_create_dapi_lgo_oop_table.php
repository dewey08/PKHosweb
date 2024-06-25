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
        if (!Schema::hasTable('dapi_lgo_oop'))
        {
            Schema::create('dapi_lgo_oop', function (Blueprint $table) {
                $table->bigIncrements('dapi_lgo_oop_id'); 
                $table->string('blobName')->nullable();//   "DRU.txt” 
                $table->string('blobType')->nullable();//   “text/plain”
                $table->longtext('blob')->nullable();//       “SE58SU5T”
                $table->string('size')->nullable();//       "32"
                $table->string('encoding')->nullable();//   “UTF-8” 
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dapi_lgo_oop');
    }
};
