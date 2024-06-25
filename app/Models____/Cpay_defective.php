<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cpay_defective extends Model
{
    use HasFactory;
    protected $table = 'cpay_defective';
    protected $primaryKey = 'DEFECTIVE_ID';
}
