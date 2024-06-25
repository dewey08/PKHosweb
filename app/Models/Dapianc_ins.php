<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Dapianc_ins extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'dapianc_ins';
    protected $primaryKey = 'dapianc_ins_id';
    protected $fillable = [
        'blobName',
        'blobType',
        'blob'         
    ];

  
}
