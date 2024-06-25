<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class D_export extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $connection = 'mysql7';
    protected $table = 'd_export';
    protected $primaryKey = 'd_export_id';
    protected $fillable = [
        'session_no', 
        'session_date', 
        'session_time',  
        'session_filename',  
        'session_ststus',
        'ACTIVE' 
    ];
    public $timestamps = false; 

  
}
