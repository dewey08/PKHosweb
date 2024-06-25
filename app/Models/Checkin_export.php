<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Auth;

class Checkin_export extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'checkin_export';
    protected $primaryKey = 'checkin_export_id';
    protected $fillable = [
        'checkindate', 
        'checkintime', 
        'ptname',
        'checkin_time',
        'checkout_time',
        'checkin_type',
        'checkin_typename',
        'userid',
        'userid_save'     
    ];

    public static function getCheckin_export(){
        $userid = Auth::user()->id;
        $result = DB::table('checkin_export')
        ->select(
            'checkindate',  
            'ptname',
            'checkin_time',
            'checkout_time',
            // 'checkin_type',
            'checkin_typename',
            // 'userid',
            // 'userid_save'      
        )
        ->where('userid',$userid)
        ->get()->toArray();
        return $result;
    }

  
}
