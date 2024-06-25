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
        if (!Schema::hasTable('d_anc_main'))
        {
            Schema::connection('mysql')->create('d_anc_main', function (Blueprint $table) {
                $table->bigIncrements('d_anc_main_id');
                $table->string('vn')->nullable();//
                $table->string('an')->nullable();// 
                $table->string('hn')->nullable();// 
                $table->string('cid')->nullable();// 
                $table->string('pttype')->nullable();// 
                $table->string('ptname')->nullable();// 
                $table->string('pdx')->nullable();// 
                $table->string('dx0')->nullable();// 
                $table->date('vstdate')->nullable();// 
                $table->string('nhso_adp_code')->nullable();// 
                $table->string('qty')->nullable();//  
                $table->string('sum_price')->nullable();// 
                $table->string('preg_no')->nullable();// 
                $table->string('gaNOW')->nullable();// 
                $table->date('lmp')->nullable();// 
                $table->date('anc_service_date')->nullable();// 
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
        Schema::dropIfExists('d_anc_main');
    }
};
