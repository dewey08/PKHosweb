<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Book_control extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'book_control';
    protected $primaryKey = 'book_control_id';
    protected $fillable = [
        'bookno',
        'datebook',
        'daterep'         
    ];
 
}
