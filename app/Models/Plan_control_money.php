<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan_control_money extends Model
{
    protected $table = 'plan_control_money';
    protected $primaryKey = 'plan_control_money_id';
    protected $fillable = [
        'plan_control_id'
      
    ];
}

