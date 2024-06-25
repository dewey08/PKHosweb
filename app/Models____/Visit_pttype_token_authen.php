<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Visit_pttype_token_authen extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'visit_pttype_token_authen';
    protected $primaryKey = 'visit_pttype_token_authen_id';
    protected $fillable = [
        'cid',
        'token'         
    ];

  
}
