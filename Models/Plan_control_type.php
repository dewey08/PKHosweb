<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan_control_type extends Model
{
    protected $table = 'plan_control_type';
    protected $primaryKey = 'plan_control_type_id';
    protected $fillable = [
        'plan_control_typename'
      
    ];
}

