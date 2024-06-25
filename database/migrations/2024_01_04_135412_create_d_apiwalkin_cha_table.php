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
        if (!Schema::hasTable('d_apiwalkin_cha'))
        {
            Schema::create('d_apiwalkin_cha', function (Blueprint $table) {
                $table->bigIncrements('d_apiwalkin_cha_id'); 
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
        Schema::dropIfExists('d_apiwalkin_cha');
    }
};
