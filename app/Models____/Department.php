<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Department extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'department';
    protected $primaryKey = 'DEPARTMENT_ID';
    protected $fillable = [
        'DEPARTMENT_NAME',
        'LINE_TOKEN',
        'LEADER_ID'
    ];


    // public function users()
    // {
    //     return $this->belongsToMany(User::class, 'LEADER_ID');
    // }
  
}
