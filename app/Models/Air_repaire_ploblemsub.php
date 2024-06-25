<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Air_repaire_ploblemsub extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'air_repaire_ploblemsub';
    protected $primaryKey = 'air_repaire_ploblemsub_id';
    protected $fillable = [
        'air_repaire_ploblem_id',
        'air_list_num', 
    ];

  
}
