<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Dapiherb_orf extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'dapiherb_orf';
    protected $primaryKey = 'dapiherb_orf_id';
    protected $fillable = [
        'blobName',
        'blobType',
        'blob'         
    ];

  
}
