<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;
class Vn_stat extends Model
{
    use HasFactory;

    protected $connection = 'mysql3';
    protected $table = 'vn_stat';
    protected $primaryKey = 'vn';
    public $timestamps = false;     
}
