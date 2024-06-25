<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class D_ofc_rep extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'd_ofc_rep';
    protected $primaryKey = 'd_ofc_rep_id';
    protected $fillable = [
        'rep_a',
        'no_b',
        'tranid_c'         
    ];

  
}
