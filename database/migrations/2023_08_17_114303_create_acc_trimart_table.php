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
        if (!Schema::hasTable('acc_trimart'))
        {
            Schema::connection('mysql')->create('acc_trimart', function (Blueprint $table) {
                $table->bigIncrements('acc_trimart_id');
                $table->string('acc_trimart_code')->nullable();//
                $table->string('acc_trimart_name')->nullable();// 
                $table->date('acc_trimart_start_date')->nullable();//
                $table->date('acc_trimart_end_date')->nullable();// 
                $table->enum('active', ['Y','N'])->default('N')->nullable(); 
                $table->timestamps();
            });

            // DB::table('acc_trimart')->truncate();

            // DB::table('acc_trimart')->insert(array(
            //     'acc_trimart_id' => '1',
            //     'acc_trimart_start' => 'ตุลาคม',
            //     'acc_trimart_end' => 'ธันวาคม',        
            //     'created_at' => date('Y-m-d H:i:s'),
            //     'updated_at' => date('Y-m-d H:i:s'),
            // ));
            // DB::table('acc_trimart')->insert(array(
            //     'acc_trimart_id' => '2',
            //     'acc_trimart_start' => 'มกราคม',
            //     'acc_trimart_end' => 'มีนาคม',          
            //     'created_at' => date('Y-m-d H:i:s'),
            //     'updated_at' => date('Y-m-d H:i:s'),
            // )); 
            // DB::table('acc_trimart')->insert(array(
            //     'acc_trimart_id' => '3',
            //     'acc_trimart_start' => 'เมษายน',
            //     'acc_trimart_end' => 'มิถุนายน',          
            //     'created_at' => date('Y-m-d H:i:s'),
            //     'updated_at' => date('Y-m-d H:i:s'),
            // )); 
            // DB::table('acc_trimart')->insert(array(
            //     'acc_trimart_id' => '4',
            //     'acc_trimart_start' => 'กรกฎาคม',
            //     'acc_trimart_end' => 'กันยายน',          
            //     'created_at' => date('Y-m-d H:i:s'),
            //     'updated_at' => date('Y-m-d H:i:s'),
            // )); 
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acc_trimart');
    }
};
