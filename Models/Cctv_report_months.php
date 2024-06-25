<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Cctv_report_months extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'cctv_report_months';
    protected $primaryKey = 'cctv_report_months_id';
    protected $fillable = [
        'cctv_check_date',
        'article_num',
        'screen_narmal'         
    ];

  
}
