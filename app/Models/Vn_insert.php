<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;
class Vn_insert extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'vn_insert';
    protected $primaryKey = 'vn';
    public $timestamps = false;     
}
