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
        if (!Schema::hasTable('account_listpercen'))
        {
        Schema::create('account_listpercen', function (Blueprint $table) {
            $table->bigIncrements('account_listpercen_id');           
            $table->string('account_listpercen_name',255)->nullable();//   
            $table->string('account_listpercen_percent',255)->nullable();// 
            $table->enum('account_listpercen_active', ['TRUE','FALSE'])->default('FALSE')->nullable();
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
        Schema::dropIfExists('account_listpercen');
    }
};
