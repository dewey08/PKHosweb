<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformationPublicizeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('information_publicize')){
            Schema::create('information_publicize', function (Blueprint $table) {
                $table->id('IPUB_ID');
            });
            DB::statement("ALTER TABLE information_publicize ADD IPUB_IMG MEDIUMBLOB");
            Schema::table('information_publicize', function (Blueprint $table) {
                $table->string('IPUB_NAME');
                $table->string('IPUB_DETAIL',400);
                $table->string('IPUB_LINK');
                $table->date('IPUB_DATE');
                $table->time('IPUB_TIME');
                $table->boolean('IPUB_ACTIVE')->default(0);
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
        Schema::dropIfExists('information_publicize');
    }
}
