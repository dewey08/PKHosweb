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
        if (!Schema::hasTable('meeting_objective'))
        {
        Schema::create('meeting_objective', function (Blueprint $table) {
            $table->bigIncrements('meeting_objective_id');  
            $table->string('meeting_objective_name')->nullable();// ชื่อสี
            $table->timestamps();
            });

            if (Schema::hasTable('meeting_objective')) {
                DB::table('meeting_objective')->truncate();
            }
            DB::table('meeting_objective')->insert(array(
                'meeting_objective_id' => '1',
                'meeting_objective_name' => 'อบรม',        
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('meeting_objective')->insert(array(
                'meeting_objective_id' => '2',
                'meeting_objective_name' => 'ประชุม',          
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('meeting_objective')->insert(array(
                'meeting_objective_id' => '3',
                'meeting_objective_name' => 'สัมนา',          
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('meeting_objective')->insert(array(
                'meeting_objective_id' => '4',
                'meeting_objective_name' => 'อื่นฯ',          
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
        Schema::dropIfExists('meeting_objective');
    }
};
