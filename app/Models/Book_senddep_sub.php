<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Book_senddep_sub extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'book_senddep_sub';
    protected $primaryKey = 'senddepsub_id';
    protected $fillable = [
        'bookrep_id', 
        'senddep_depsub_id', 
        'senddep_depsub_name',       
    ];

  
}
