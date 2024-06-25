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
        if (!Schema::hasTable('d_ktb_b17'))
        {
            Schema::connection('mysql7')->create('d_ktb_b17', function (Blueprint $table) {
                $table->bigIncrements('d_ktb_b17_id'); 
                $table->enum('status', ['PULL','PASS','CANCEL','NOPASS','SEND'])->default('PULL')->nullable();
                $table->string('vn',255)->nullable(); 
                $table->string('hn',255)->nullable();   
                $table->string('an',255)->nullable(); 
                $table->string('cid',255)->nullable();  
                $table->date('vstdate')->nullable(); 
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
        Schema::dropIfExists('d_ktb_b17');
    }
};
