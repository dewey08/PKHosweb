<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cpay_department_sub_sub_quota_user extends Model
{
    use HasFactory; 
    protected $table = 'cpay_department_sub_sub_quota';
    protected $primaryKey = 'DEP_QUOTA_ID'; 
}
