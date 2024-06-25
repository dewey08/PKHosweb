<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddcolumnDonationWealth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('donation_wealth', function (Blueprint $table) {
         
            if (!Schema::hasColumn('donation_wealth', 'updated_at')) // Update Column ในกรณีที่ไม่มี
            {
                $table->dateTime("updated_at")->nullable();
            }  
            if (!Schema::hasColumn('donation_wealth', 'created_at'))
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
        // Schema::dropIfExists('donation_wealth');
    }
}
