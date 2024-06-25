<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disburse_status extends Model
{
    protected $table = 'warehouse_disburse_status';
    protected $primaryKey = 'ID_STATUS';
    public $timestamps = false;
}