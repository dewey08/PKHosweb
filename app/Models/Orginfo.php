<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Orginfo extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'orginfo';
    protected $primaryKey = 'orginfo_id';
    protected $fillable = [
        'orginfo_link' ,
        'orginfo_manage_id' ,
        'orginfo_po_id'      
    ];

  
}
