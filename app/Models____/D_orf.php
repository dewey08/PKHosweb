<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class D_orf extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $connection = 'mysql7';
    protected $table = 'd_orf';
    protected $primaryKey = 'd_orf_id';
    protected $fillable = [ 
        'HN', 
        'DATEOPD',  
        'CLINIC',  
        'REFER',
        'REFERTYPE', 
        'SEQ' 
    ];

  
}
