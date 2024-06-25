<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;
class Ptdepart extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'ptdepart';
    protected $primaryKey = 'vn';
    public $timestamps = false;     
}
