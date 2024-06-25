<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddcolumnDonationUnit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('donation_unit', function (Blueprint $table) {
         
            if (!Schema::hasColumn('donation_unit', 'updated_at')) // Update Column ในกรณีที่ไม่มี
            {
                $table->dateTime("updated_at")->nullable();
            }  
            if (!Schema::hasColumn('donation_unit', 'created_at'))
            {
                $table->dateTime("created_at")->nullable();
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
        //  Schema::dropIfExists('donation_unit');
    }
}
