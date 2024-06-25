<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Department_sub_sub extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'department_sub_sub';
    protected $primaryKey = 'DEPARTMENT_SUB_SUB_ID';
    protected $fillable = [
        'DEPARTMENT_SUB_SUB_NAME',
        'BOOK_NUM',
        'LEADER_HR_ID',
        'DEPARTMENT_SUB_ID',
        'DEP_CODE',
        'PHONE_IN',
        'LINE_TOKEN',
        'active'           
    ];

  
}
