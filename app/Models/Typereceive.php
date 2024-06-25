<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Typereceive extends Model
{
    protected $table = 'warehouse_check_type';
    protected $primaryKey = 'ID_TYPE';
    public $timestamps = false;
}