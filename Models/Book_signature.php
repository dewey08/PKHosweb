<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Book_signature extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'book_signature';
    protected $primaryKey = 'signature_id';
    protected $fillable = [
        'user_id', 
        'signature_name', 
        'signature_name_text',       
    ];

  
}
