<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disburse_cycle extends Model
{
    protected $table = 'warehouse_disburse_cycle';
    protected $primaryKey = 'ID_CYCLE';
    public $timestamps = false;
}