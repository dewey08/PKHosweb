<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;
use Illuminate\Contracts\Auth\MustVerifyEmail; 
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class A_ct_scan_visit extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'a_ct_scan_visit'; 
    // protected $primaryKey = 'a_ct_scan_visit_id';
    protected $fillable = [
        'vn', 
        'hn', 
        'cid', 
        'ptname',
        'xray_list',
        'confirm_all',
        'department',
        'department_code',
        'department_name',
        'pttype',
        'xray_order_number',
        'xray_price',
        'total_price',
        'department_list',
        'priority_name',
        'STMdoc', 
        'user_id' 
    ];
    // public $timestamps = false; 

  
}
