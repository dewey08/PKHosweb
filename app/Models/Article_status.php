<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Article_status extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'article_status';
    protected $primaryKey = 'article_status_id';
    protected $fillable = [
        'article_status_code',
        'article_status_name'
    ];

  
}
