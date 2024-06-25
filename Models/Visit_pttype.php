<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class Visit_pttype extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $connection = 'mysql10';
    protected $table = 'visit_pttype';
    protected $primaryKey = 'vn';
    protected $fillable = [  
        'vn',
        'claim_code' 
    ];
    public $timestamps = false;     
}
