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
        if (!Schema::hasTable('pt_restore_type'))
        {
        Schema::create('pt_restore_type', function (Blueprint $table) {
            $table->bigIncrements('pt_restore_type_id'); 
            $table->string('pt_restore_type_code',255)->nullable();//
            $table->string('pt_restore_type_name',255)->nullable();//ชั้นความลับ     
            $table->timestamps();
        }); 
        
        if (Schema::hasTable('pt_restore_type')) {
            DB::table('pt_restore_type')->truncate();
        }
        DB::table('pt_restore_type')->insert(array(
            'pt_restore_type_id' => '1',
            'pt_restore_type_code' => 'KA01',
            'pt_restore_type_name' => 'กายภาพ',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('pt_restore_type')->insert(array(
            'pt_restore_type_id' => '2',
            'pt_restore_type_code' => 'KA02',
            'pt_restore_type_name' => 'หู คอ จมูก',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));   
        DB::table('pt_restore_type')->insert(array(
            'pt_restore_type_id' => '3',
            'pt_restore_type_code' => 'KA03',
            'pt_restore_type_name' => 'ตา',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('pt_restore_type')->insert(array(
            'pt_restore_type_id' => '4',
            'pt_restore_type_code' => 'KA04',
            'pt_restore_type_name' => 'จิต/Day care/ยาเสพติด',          
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('pt_restore_type')->insert(array(
            'pt_restore_type_id' => '5',
            'pt_restore_type_code' => 'KA05',
            'pt_restore_type_name' => 'กระตุ้นพัฒนาการ',          
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
        Schema::dropIfExists('pt_restore_type');
    }
};
