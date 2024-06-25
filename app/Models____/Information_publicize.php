<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information_publicize extends Model
{
    use HasFactory;
    protected $table = 'information_publicize';
    protected $primaryKey = 'IPUB_ID';

    public static function getPublicize($number = 5)
    {
        return Information_publicize::where('IPUB_ACTIVE',TRUE)->orderByDesc('IPUB_DATE')->orderByDesc('IPUB_TIME')->limit($number)->get();
    }

    public static function getAllPublicize($number = 500){
        return Information_publicize::orderByDesc('updated_at')->orderByDesc('IPUB_ID')->limit($number)->get();
    }
    
}
