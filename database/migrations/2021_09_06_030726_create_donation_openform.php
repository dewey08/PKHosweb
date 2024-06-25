<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationOpenform extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('donation_openform', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        // });
        if (!Schema::hasTable('donation_openform'))
        {
                Schema::create('donation_openform', function (Blueprint $table) {
                    $table->id("OPENFORM_ID",11);
                    $table->String("OPENFORM_CODE",255)->nullable(); 
                    $table->String("OPENFORM_NAME",255)->nullable(); 
                    $table->enum('OPENFORM_STATUS', ['True', 'False']);   
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
        Schema::dropIfExists('donation_openform');
    }
}
