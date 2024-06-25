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
        if (!Schema::hasTable('book_import_fam'))
        {
        Schema::create('book_import_fam', function (Blueprint $table) {
            $table->bigIncrements('import_fam_id');   
            $table->string('import_fam_name',255)->nullable();//ชื่อแฟ้ม 
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
        Schema::dropIfExists('book_import_fam');
    }
};
