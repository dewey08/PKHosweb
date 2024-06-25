<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cpay_export_list extends Model
{
    use HasFactory;
    protected $table = 'cpay_export_list';
    protected $primaryKey = 'EXPORT_LIST_ID';
}
