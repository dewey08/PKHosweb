<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Com_repaire_signature extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'com_repaire_signature';
    protected $primaryKey = 'signature_id';
    protected $fillable = [
        'com_repaire_id', 
        'com_repaire_no', 
        'signature_name_usertext',  
        'signature_name_stafftext',      
    ];

  
}
