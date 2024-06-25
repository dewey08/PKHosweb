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
        if (!Schema::hasTable('secret_class'))
        {
        Schema::create('secret_class', function (Blueprint $table) {
            $table->bigIncrements('secret_class_id'); 
            $table->string('secret_class_name',255)->nullable();//ชั้นความลับ     
            $table->timestamps();
        }); 
        // if (Schema::hasTable('secret_class')) {
        //     DB::table('secret_class')->truncate();
        // }
        DB::table('secret_class')->insert(array(
            'secret_class_id' => '1',
            'secret_class_name' => 'ปกติ',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('secret_class')->insert(array(
            'secret_class_id' => '2',
            'secret_class_name' => 'ลับ',          
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
        Schema::dropIfExists('secret_class');
    }
};
