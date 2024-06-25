<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan_control extends Model
{
    protected $table = 'plan_control';
    protected $primaryKey = 'plan_control_id';
    protected $fillable = [
        'billno'
      
    ];
}

