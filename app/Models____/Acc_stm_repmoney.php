<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Acc_stm_repmoney extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'acc_stm_repmoney';
    protected $primaryKey = 'acc_stm_repmoney_id';
    protected $fillable = [
        'acc_stm_repmoney_tri',
        'acc_stm_repmoney_book'  
    ];
 
}
