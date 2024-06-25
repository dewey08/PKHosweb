<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medical_set_category extends Model
{
    use HasFactory;
    protected $table = 'medical_set_category';
    protected $primaryKey = 'SETCATEGORY_ID';
}
