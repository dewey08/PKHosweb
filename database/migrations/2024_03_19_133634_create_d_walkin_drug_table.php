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
        if (!Schema::hasTable('d_walkin_drug'))
        {
            Schema::connection('mysql')->create('d_walkin_drug', function (Blueprint $table) {
                $table->bigIncrements('d_walkin_drug_id');  
                $table->string('VN',length: 15)->nullable();//  
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('d_walkin_drug');
    }
};
