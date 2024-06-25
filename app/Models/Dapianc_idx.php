<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Dapianc_idx extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'dapianc_idx';
    protected $primaryKey = 'dapianc_idx_id';
    protected $fillable = [
        'blobName',
        'blobType',
        'blob'         
    ];

  
}
