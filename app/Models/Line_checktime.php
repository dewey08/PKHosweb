<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Line_checktime extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $connection = 'mysql6';
    protected $table = 'line_checktime';
    protected $primaryKey = 'id';
    protected $fillable = [
        'cid', 
        'tdate', 
        'checktime',
        'checktype',
        'latitude',
        'longitude',
        'location_id'
    ];

  
}
