<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Departmentsub extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'department_sub';
    protected $primaryKey = 'DEPARTMENT_SUB_ID';
    protected $fillable = [
        'DEPARTMENT_SUB_NAME',
        'LINE_TOKEN'
    ];

  
}
