<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statuscheck extends Model
{
    protected $table = 'warehouse_check_status';
    protected $primaryKey = 'ID_STATUS';
    public $timestamps = false;
}