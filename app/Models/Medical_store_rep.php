<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Medical_store_rep extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'medical_store_rep';
    protected $primaryKey = 'medical_store_rep_id';
    protected $fillable = [
        'year' ,
        'date_rep' ,
        'medical_typecat_id'      
    ];

  
}
