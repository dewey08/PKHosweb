<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;
class Visit_pttype extends Model
{
    use HasFactory;

    protected $connection = 'mysql3';
    protected $table = 'visit_pttype';
    protected $primaryKey = 'vn';
    public $timestamps = false;     
}
