<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class Refer_cross extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'refer_cross';
    protected $primaryKey = 'refer_cross_id';
    protected $fillable = [
        'vn',
        'an',
        'hn',
        'cid',
        'vstdate',
        'vsttime',
        'ptname',
        'pttype',
        'hospcode',
        'hospmain', 
        'pdx',
        'dx0',
        'dx1',
        'income',
        'refer',
        'Total'         
    ];

    public static function getallRefercross(){
        $result = DB::table('refer_cross')
        ->select(
            'vn',
            'an',
            'hn',
            'cid',
            'vstdate',
            'vsttime',
            'ptname',
            'pttype',
            'hospcode',
            'hospmain', 
            'pdx',
            'dx0',
            'dx1',
            'income',
            'refer',
            'Total'         
        )->get()->toArray();
        return $result;
    }

  
}
