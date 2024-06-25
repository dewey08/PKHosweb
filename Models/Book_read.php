<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Book_read extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'book_read';
    protected $primaryKey = 'book_read_id';
    protected $fillable = [
        'bookrep_id',  
        'book_read_useropen_id' ,
            'book_read_date',
            'book_read_time',
            'status_book_read'
    ];

  
}
