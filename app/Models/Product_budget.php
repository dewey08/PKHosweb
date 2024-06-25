<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Product_budget extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'product_budget';
    protected $primaryKey = 'budget_id';
    protected $fillable = [
        'budget_name',
        'budget_num',
        'active'
        
    ];

  
}
