<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;
class Visit_pttype_217 extends Model
{
    use HasFactory;

    // protected $connection = 'mysql';
    protected $connection = 'mysql11';
    protected $table = 'visit_pttype';
    protected $primaryKey = 'vn';
    protected $fillable = [
        'vn',
        'claim_code',
        
    ];
    public $timestamps = false;     
}
