<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Plan_kpi extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'plan_kpi';
    protected $primaryKey = 'plan_kpi_id';
    protected $fillable = [
        'plan_kpi_code',
        'plan_kpi_name'
      
    ];

  
}
