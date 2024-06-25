<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Land extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'land_data';
    protected $primaryKey = 'land_id';
    protected $fillable = [
        'land_tonnage_number',
        'land_no',
        'land_tonnage_no',
        'land_explore_page',
        'land_house_number',
        'land_province_location',
        'land_district_location',
        'land_tumbon_location',
        'land_poscode'
            
    ];

  
}
