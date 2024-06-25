<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cpay_production extends Model
{
    use HasFactory;
    protected $table = 'cpay_production';
    protected $primaryKey = 'PRODUCT_ID';
}
