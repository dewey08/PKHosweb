<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information_facebook_page extends Model
{
    use HasFactory;
    protected $table = 'information_facebook_page';
    protected $primaryKey = 'IFP_ID';

    public static function getFacebookpage()
    {
        return Information_facebook_page::where('IFP_ACTIVE',True)->orderByDesc('updated_at')->first();
    }

    public static function getAllFacebookpage()
    {
        return Information_facebook_page::orderByDesc('updated_at')->get();
    }

}
