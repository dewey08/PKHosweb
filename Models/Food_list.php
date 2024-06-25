<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Food_list extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'food_list';
    protected $primaryKey = 'food_list_id';
    protected $fillable = [
        'food_list_name' ,
        'food_list_img' ,
        'food_list_qty' 
    ];

  
}
