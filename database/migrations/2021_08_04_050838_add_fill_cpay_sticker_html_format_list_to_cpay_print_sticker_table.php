<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillCpayStickerHtmlFormatListToCpayPrintStickerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('cpay_print_sticker', function (Blueprint $table) {
            if (!Schema::hasColumn('cpay_print_sticker', 'CPAY_STICKER_HTML_FORMAT_LIST'))
            {
                $table->text('CPAY_STICKER_HTML_FORMAT_LIST')->nullable();
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
        Schema::table('cpay_print_sticker', function (Blueprint $table) {
            //
        });
    }
}
