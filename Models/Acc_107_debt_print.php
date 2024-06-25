<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Acc_107_debt_print extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'acc_107_debt_print';
    protected $primaryKey = 'acc_107_debt_print_id';
    protected $fillable = [
        '106_debt_no',
        '106_debt_count',
        '106_debt_date'         
    ];

  
}
