<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZapuser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {     
        if (!Schema::hasTable('zapuser'))
        {
                Schema::create('zapuser', function (Blueprint $table) {
                    $table->id("zap_id",11);
                    $table->String("zap_fullname",255); 
                    $table->String("zap_email",255); 
                    $table->String("zap_username",255); 
                    $table->String("zap_password",255); 
                    $table->enum('zap_type', ['USER', 'ADMIN' , 'NOTUSER']);   
                    $table->dateTime('updated_at');
                    $table->dateTime('created_at');
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
        Schema::dropIfExists('zapuser');
    }
}
