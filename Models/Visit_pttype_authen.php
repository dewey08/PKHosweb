<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;
class Visit_pttype_authen extends Model
{
    use HasFactory;

    protected $connection = 'mysql3';
    protected $table = 'visit_pttype_authen';
    protected $primaryKey = 'visit_pttype_authen_id';
    protected $fillable = [
        'visit_pttype_authen_cid',
        'visit_pttype_authen_vn',
        'visit_pttype_authen_hn',
        'visit_pttype_authen_auth_code',
        'visit_pttype_authen_fullname',
        'visit_pttype_authen_department',
        'visit_pttype_authen_staff',
        'visit_pttype_authen_name',
        'checkTime',
        'claimDate',
        'main_dep'
    ];
    public $timestamps = false;     
}
