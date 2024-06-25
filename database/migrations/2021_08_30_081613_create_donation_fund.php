<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationFund extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {               

        Schema::table('donation_fund', function (Blueprint $table) {

            if (Schema::hasColumn('donation_fund', 'DONATE_FUND_ID')) {
                $table->increments('DONATE_FUND_ID')->change();   // Update primary ให้เป็น Auto increment
            }
            if (!Schema::hasColumn('donation_fund', 'updated_at')) // Update Column ในกรณีที่ไม่มี
            {
                $table->dateTime("updated_at");
            }  
            if (!Schema::hasColumn('donation_fund', 'created_at'))
            {
                $table->dateTime("created_at");
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
        // Schema::dropIfExists('donation_fund');
    }
}
