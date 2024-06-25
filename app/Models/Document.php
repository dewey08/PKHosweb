<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Document extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'document';
    protected $primaryKey = 'document_id';
    protected $fillable = [
        'document_name',
        'img',
        'img_name'
         
    ];

  
}
