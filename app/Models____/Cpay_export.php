<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cpay_export extends Model
{
    use HasFactory;
    protected $table = 'cpay_export';
    protected $primaryKey = 'EXPORT_ID';
}
