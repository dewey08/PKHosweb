<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class P4p_work_score extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'p4p_work_score';
    protected $primaryKey = 'p4p_work_score_id';
    protected $fillable = [
        'p4p_work_id'
      
    ];

  
}
