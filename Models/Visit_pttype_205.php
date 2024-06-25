<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;
class Visit_pttype_205 extends Model
{
    use HasFactory;

    // protected $connection = 'mysql';
    protected $connection = 'mysql3';
    protected $table = 'visit_pttype';
    protected $primaryKey = 'vn';
    protected $fillable = [
        'vn',
        'claim_code',
        
    ];
    public $timestamps = false;  
    
    // protected $connection = 'mysql3';
    // protected $table = 'check_sit_auto';
    // protected $primaryKey = 'check_sit_auto_id';
    // protected $fillable = [  
    //     'vn',
    //     'hn',  
    //     'cid', 
    //     'vstdate',
    //     'vsttime',
    //     'pttype',
    //     'fullname',
    //     'staff'
    // ];
}
