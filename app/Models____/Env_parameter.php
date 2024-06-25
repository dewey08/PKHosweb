<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Env_parameter extends Model
{
    protected $table = 'env_parameter';
    protected $primaryKey = 'PARAMETER_ID';
    public $timestamps = false;
}