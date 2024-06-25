<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Building extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'building_data';
    protected $primaryKey = 'building_id';
    protected $fillable = [
        'building_decline_id',
        'building_decline_name',
        'building_tonnage_number',
        'building_budget_id',
        'building_budget_name',
        'building_method_id',
        'building_method_name',
        'building_budget_price',
        'building_amount',
        'building_long'
            
    ];

  
}
