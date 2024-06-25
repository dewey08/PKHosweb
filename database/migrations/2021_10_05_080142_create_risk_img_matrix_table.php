<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskImgMatrixTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('risk_img_matrix'))
        {

            Schema::create('risk_img_matrix', function (Blueprint $table) {
                $table->id("RISK_IMG_ID",10);          
                $table->binary('RISK_IMG_MATRIX'); 
                $table->dateTime('updated_at')->nullable();
                $table->dateTime('created_at')->nullable();
            });


            if (Schema::hasTable('risk_img_matrix')) {
                DB::table('risk_img_matrix')->truncate();
            }

            DB::table('risk_img_matrix')->insert(array(
                'RISK_IMG_ID' => '1',
                'RISK_IMG_MATRIX' => '',
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
        Schema::dropIfExists('risk_img_matrix');
    }
}
