<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incidence extends Model
{
    protected $table = 'risk_incidence';
    protected $primaryKey = 'RISK_INCIDENCE_ID';
    public $timestamps = false;
}