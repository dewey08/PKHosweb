<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan_control_kpi extends Model
{
    protected $table = 'plan_control_kpi';
    protected $primaryKey = 'plan_control_kpi_id';
    protected $fillable = [
        'plan_control_id'
      
    ];
}

