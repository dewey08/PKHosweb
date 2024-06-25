<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;
class Pttypehistory extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'pttypehistory';
    protected $primaryKey = 'hn';
    public $timestamps = false;     
}
