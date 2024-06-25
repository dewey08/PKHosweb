<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;
class Service_time extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'service_time';
    protected $primaryKey = 'vn';
    public $timestamps = false;     
}
