<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Book_import_fam extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'book_import_fam';
    protected $primaryKey = 'import_fam_id';
    protected $fillable = [
        'import_fam_name',       
    ];

  
}
