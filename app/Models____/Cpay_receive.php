<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cpay_receive extends Model
{
    use HasFactory;
    protected $table = 'cpay_receive';
    protected $primaryKey = 'RECEIVE_ID';
}
