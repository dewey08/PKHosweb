<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Medical_borrow extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'medical_borrow';
    protected $primaryKey = 'medical_borrow_id';
    protected $fillable = [
        'medical_borrow_date' ,
        'medical_borrow_backdate' ,
        'medical_borrow_article_id'      
    ];

  
}
