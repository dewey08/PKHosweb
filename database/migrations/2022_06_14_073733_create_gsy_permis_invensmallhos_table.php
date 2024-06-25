<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGsyPermisInvensmallhosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        if(!Schema::hasTable('gsy_permis_invensmallhos')){ 

            Schema::create('gsy_permis_invensmallhos', function (Blueprint $table) {
           
                $table->increments("INVEN_SMALLHOS_ID",11);
                $table->integer("INVEN_SMALLHOS_IDSMALL")->nullable(); 
                $table->String("INVEN_SMALLHOS_NAMESMALL",255)->nullable(); 
                $table->integer("INVEN_SMALLHOS_IDINVEN")->nullable(); 
                $table->String("INVEN_SMALLHOS_NAMEINVEN",255)->nullable();                      
                $table->dateTime('updated_at')->nullable();
                $table->dateTime('created_at')->nullable();  

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
        Schema::dropIfExists('gsy_permis_invensmallhos');
    }
}
