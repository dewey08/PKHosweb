<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillToSuppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
                Schema::table('supplies', function (Blueprint $table) {
                    if (!Schema::hasColumn('supplies', 'SUP_BUY'))
                        {
                            $table->String("SUP_BUY",255)->nullable();
                        }

                        if (!Schema::hasColumn('supplies', 'DIS_ACTIVE'))
                        {
                            $table->enum('DIS_ACTIVE', ['False', 'True']);
                        }

                        if (!Schema::hasColumn('supplies', 'INNO_ACTIVE'))
                        {
                            $table->enum('INNO_ACTIVE', ['False', 'True']);
                        }
                        
                        if (!Schema::hasColumn('supplies', 'SUP_MASH'))
                        {
                            $table->String("SUP_MASH",255);
                        }
                    
                    
                   
                });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('supplies', function (Blueprint $table) {
            //
        });
    }
}
