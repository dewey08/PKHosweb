<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Book_send_person extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'book_send_person';
    protected $primaryKey = 'sendperson_id';
    protected $fillable = [
        'bookrep_id', 
        'sendperson_user_id', 
        'sendperson_user_name',       
    ];

  
}
