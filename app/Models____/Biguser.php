<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biguser extends Model
{
    use HasFactory;
    protected $table = 'biguser';
    protected $fillable = [
        'fullname', 'username','password','email','status'
        ];
}
