<?php

namespace App\Models;
// use App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;
use Illuminate\Contracts\Auth\MustVerifyEmail; 
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Env_pond_sub extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'env_pond_sub';
    // protected $primaryKey = 'pond_sub_id'; 
    protected $fillable = [
        'pond_id',
        'pond_name'

              
    ];

    
}
