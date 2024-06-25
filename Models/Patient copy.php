<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;
class Patient extends Model
{
    use HasFactory;
    protected $connection = 'mysql3';
    protected $table = 'patient';
    protected $primaryKey = 'hos_guid';
    public $timestamps = false;
    // protected $fillable = [
    //     'hn',
    //     'pname',
    //     'fname',
    //     'lname',
    //     'pttype',
    //     'hcode',
    //     'cid',
    //     'hometel',
    //     'informtel'
            
    // ]; 

}
