<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformationFacebookPageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('information_facebook_page')){
            Schema::create('information_facebook_page', function (Blueprint $table) {
                $table->id('IFP_ID');
                $table->string('IFP_PLUGIN',400);
                $table->string('IFP_DATASHOW',1000);
                $table->boolean('IFP_ACTIVE')->default(0);
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
        Schema::dropIfExists('information_facebook_page');
    }
}
