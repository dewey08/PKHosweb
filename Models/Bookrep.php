<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Bookrep extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'bookrep';
    protected $primaryKey = 'bookrep_id';
    protected $fillable = [
        'bookrep_year', 
        'bookrep_repnum', 
        'bookrep_recievenum',  
        'bookrep_file1',      
    ];

  
}
