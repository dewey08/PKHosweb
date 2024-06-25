<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Env_trash_sub extends Model
{
    protected $table = 'env_trash_sub';
    protected $primaryKey = 'trash_sub_id';
    // public $timestamps = false;
    protected $fillable = [
        'trash_id',
        'trash_sub_name',
        'trash_sub_qty',
        'trash_sub_unit',
        'trash_sub_idd'
        // 'parameter_list_user_analysis_results'
        
    ];

}
