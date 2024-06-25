<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehousereportmain extends Model
{
    protected $table = 'warehouse_reportmain';
    // protected $primaryKey = 'REPMAIN_ID';
    protected $fillable = [
        'REPMAIN_ID',
        'REPMAIN_YEAR',
        'REPMAIN_MOUNT',
        'REPMAIN_LISTTYPE_ID',
        'REPMAIN_LISTTYPE_NAME',
        'REPMAIN_TOTAL_MAIN',
        'REPMAIN_TOTAL_SUB',
        'REPMAIN_TOTAL_MAINSUB',
        'REPMAIN_TOTAL_BUY',
        'REPMAIN_TOTAL_MAINSUBBUY',
        'REPMAIN_TOTAL_PAY_RPST',
        'REPMAIN_TOTAL_PAY_RPR_MAIN',
        'REPMAIN_TOTAL_PAY_RPR_SUB',
        'REPMAIN_TOTAL_CUTMAIN',
        'REPMAIN_TOTAL_CUTSUB'
    ];
}
