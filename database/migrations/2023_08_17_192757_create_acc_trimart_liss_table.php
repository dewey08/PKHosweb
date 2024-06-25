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
         
        if (!Schema::hasTable('acc_trimart_liss'))
        {
            Schema::connection('mysql')->create('acc_trimart_liss', function (Blueprint $table) {
                $table->bigIncrements('acc_trimart_liss_id');
                $table->string('acc_trimart_liss_start')->nullable();//
                $table->string('acc_trimart_liss_end')->nullable();//  
                $table->enum('active', ['Y','N'])->default('N')->nullable(); 
                $table->timestamps();
            });

            DB::table('acc_trimart_liss')->truncate();

            DB::table('acc_trimart_liss')->insert(array(
                'acc_trimart_liss_id' => '1',
                'acc_trimart_liss_start' => 'ตุลาคม',
                'acc_trimart_liss_end' => 'ธันวาคม',        
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('acc_trimart_liss')->insert(array(
                'acc_trimart_liss_id' => '2',
                'acc_trimart_liss_start' => 'มกราคม',
                'acc_trimart_liss_end' => 'มีนาคม',          
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('acc_trimart_liss')->insert(array(
                'acc_trimart_liss_id' => '3',
                'acc_trimart_liss_start' => 'เมษายน',
                'acc_trimart_liss_end' => 'มิถุนายน',          
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('acc_trimart_liss')->insert(array(
                'acc_trimart_liss_id' => '4',
                'acc_trimart_liss_start' => 'กรกฎาคม',
                'acc_trimart_liss_end' => 'กันยายน',          
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acc_trimart_liss_liss');
    }
};
