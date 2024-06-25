<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Env_trash extends Model
{
    protected $table = 'env_trash';
    protected $primaryKey = 'trash_id';
    // public $timestamps = false;
    protected $fillable = [
        'trash_bill_on',
        'trash_date',
        'trash_time',
        'trash_user',
        'trash_sub'
        // 'parameter_list_user_analysis_results'
        
    ];

}
