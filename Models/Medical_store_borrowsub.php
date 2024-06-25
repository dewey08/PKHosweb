<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Medical_store_borrowsub extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'medical_store_borrowsub';
    protected $primaryKey = 'medical_store_borrowsub_id';
    protected $fillable = [
        'medical_store_borrow_id' ,
        'date_borrow_go' ,
        'time_borrow_go'      
    ];

  
}
