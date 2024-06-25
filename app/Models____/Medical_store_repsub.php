<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Medical_store_repsub extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'medical_store_repsub';
    protected $primaryKey = 'medical_store_repsub_id';
    protected $fillable = [
        'medical_store_rep_id' ,
        'article_id' ,
        'article_unit_id'      
    ];

  
}
