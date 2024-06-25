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
        if (!Schema::hasTable('six_temp'))
        {
            Schema::connection('mysql7')->create('six_temp', function (Blueprint $table) {
                $table->bigIncrements('six_temp_id'); 
                $table->enum('status', ['PULL','PASS','CANCEL','NOPASS','SEND'])->default('PULL')->nullable();
                $table->string('vn',255)->nullable(); 
                $table->string('hn',255)->nullable();   
                $table->string('an',255)->nullable(); 
                $table->string('cid',255)->nullable(); 
                $table->string('fullname',255)->nullable();  
                $table->string('inscl',255)->nullable(); 
                $table->string('pdx',255)->nullable(); 
                $table->string('drug',255)->nullable(); 
                $table->string('money_hosxp',255)->nullable(); 
                $table->string('paidst',255)->nullable(); 
                $table->string('discount_money',255)->nullable(); 
                $table->string('rcpt_money',255)->nullable(); 
                $table->string('debit',255)->nullable(); 
                $table->enum('active', ['REP','APPROVE','CANCEL','FINISH','SEND'])->default('SEND')->nullable();
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
        Schema::dropIfExists('six_temp');
    }
};
