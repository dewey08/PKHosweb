<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan_control_activity extends Model
{
    protected $table = 'plan_control_activity';
    protected $primaryKey = 'plan_control_activity_id';
    protected $fillable = [
        'plan_control_id'
      
    ];
}

