<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Patientpk extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'patientpk';
    protected $primaryKey = 'patientpk_id';
    protected $fillable = [
        'patientpk_name',
        'patientpk_email',
        'patientpk_subject'         
    ];

  
}
