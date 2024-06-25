<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Book_sendteam extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'book_sendteam';
    protected $primaryKey = 'sendteam_id';
    protected $fillable = [
        'bookrep_id', 
        'sendteam_team_id', 
        'sendteam_team_name',       
    ];

  
}
